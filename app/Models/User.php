<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable, searchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'phone',
        'status',
        'user_image',
        'email_verified_at',
        'receive_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['full_name', 'role_names'];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.username' => 10,
            'users.email' => 10,
            'users.phone' => 10,
        ],
    ];

    public function isAdminOrSupervisor()
    {
        return auth()->user()->hasRole('admin') || auth()->user()->hasRole('supervisor');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ordersPaid(): HasMany
    {
        return $this->hasMany(Order::class)
            ->whereIn('order_status', [Order::PAID]);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 1 ? 'Active' : 'Inactive';
    }


    public function rated(Product $product)
    {
        return $this->ratings->where('product_id', $product->id)->isNotEmpty();
    }

    public function productRating(Product $product)
    {
        return $this->rated($product) ? $this->ratings->where('product_id', $product->id)->first() : NULL;
    }

    public function ratedPurches()
    {
        return $this->belongsToMany(Product::class)->withPivot(['is_paid'])->wherePivot('id_paid', true);

    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getRoleNamesAttribute() {
        return $this->roles ? $this->roles()->pluck('display_name') : [];
    }
}

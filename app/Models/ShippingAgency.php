<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class ShippingAgency extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'out_of_town',
        'cost',
        'can_pay_on_delivery',
        'status',
        'city_id'
    ];

    protected $searchable = [
        'columns' => [
            'shipping_agencies.name' => 10,
        ],
    ];

    public function getStatusAttribute(): string
    {
        return $this->attributes['status'] == 1 ? 'Active' : 'Inactive';
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}

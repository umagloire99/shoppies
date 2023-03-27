<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;
    use HasFactory, Sluggable, SearchableTrait;

    protected $guarded = [];
    public $translatable = ['name', 'description', 'details', 'usages', 'features'];

    public $appends = ['img'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $searchable = [

        'columns' => [
            'products.name' => 10,
            'products.slug' => 10
        ],
    ];

    public function getStatusAttribute(): string
    {
        return $this->attributes['status'] == 0 ? 'Inactive' : 'Active';
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function scopeHasQuantity($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeActiveCategory($query)
    {
        return $query->whereHas('category', function ($query) {
            $query->whereStatus(1);
        });
    }

    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productCountries()
    {
        return $this->hasMany(ProductCountry::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->wherePivot('quantity');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->orderBy( 'id','desc');
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->whereStatus(1)->orderBy( 'id', 'desc');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('file_size', 'asc');
    }

    public function firstMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereNotIn('file_type', videoFormat() )
            ->orderBy('file_sort', 'asc');
    }

    public function discount(): HasOne
    {
        return $this->hasOne(ProductDiscount::class)->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function getPriceAttribute($value)
    {
        if ($this->pivot && $this->pivot->price) {
            return $this->pivot->price;
        }
        return $value;
    }

    public function getQuantityAttribute($value)
    {
        if ($this->pivot && $this->pivot->quantity) {
            return $this->pivot->quantity;
        }
        return $value;
    }

    public function getImgAttribute() {
        if ($this->firstMedia) {
            return asset('storage/images/products/' . $this->firstMedia->file_name);
        } else {
            return null;
        }
    }

}

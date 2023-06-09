<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\City;
use App\Models\Country;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserAddress extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'user_addresses.address_title' => 10,
            'user_addresses.first_name' => 10,
            'user_addresses.last_name' => 10,
            'user_addresses.email' => 10,
            'user_addresses.phone' => 10,
            'user_addresses.address' => 10,
            'users.first_name' => 10,
            'users.username' => 10,
            'users.email' => 10,
            'users.phone' => 10,
            'countries.name' => 10,
            'states.name' => 10,
            'cities.name' => 10,
        ],
        'joins' => [
            'users' => ['users.id', 'user_addresses.user_id'],
            'countries' => ['countries.id', 'user_addresses.country_id'],
            'states' => ['states.id', 'user_addresses.state_id'],
            'cities' => ['cities.id', 'user_addresses.city_id'],
        ]
    ];

    public function getDefaultAddressAttribute(): string
    {
        return $this->attributes['default_address'] == 1 ? 'Default Address' : '';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}

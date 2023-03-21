<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class PaymentMethod extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];
    protected $dates = [
        'expires_at',
    ];
    protected $searchable = [
        'columns' => [
            'payment_methods.name' => 10,
            'payment_methods.code' => 10,
        ],
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}

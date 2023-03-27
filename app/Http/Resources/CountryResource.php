<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    private Product $product;
    public function __construct($resource, Product $product)
    {
        $this->product = $product;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $productCountry = $this->product->productCountries->where('country_id', $this->id)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_name' => $this->short_name,
            'price' => $productCountry?->price,
            'quantity' => $productCountry?->quantity
        ];
    }
}

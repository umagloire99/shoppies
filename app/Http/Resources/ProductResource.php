<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description'=> $this->description,
            'features' => $this->features,
            'usages' => $this->features,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category' => new CategoryResource($this->category),
            'featured' => $this->featured
        ];
    }
}

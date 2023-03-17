<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\ProductPhotos\ProductPhotosResource;
use App\Http\Resources\Stock\StockResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * returns a product with its relations
 */
class ProductResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'   =>     $this->id,
            'name' =>     $this->name,
            'price' =>    $this->price,
            'category' => new CategoryResource($this->category),
            'stock'    => new StockResource($this->stock),
            'photos' => new ProductPhotosResource($this->phots),
        ];
    }
}

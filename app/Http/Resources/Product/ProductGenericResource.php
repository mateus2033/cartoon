<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Stock\StockResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * return product with yours basic information.
 */
class ProductGenericResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $products      = $this->resource;
        $productAux    = [];
        $productResult = [];
      
        foreach($products as $product) {
            $productAux['id']   = $product->id;
            $productAux['name'] = $product->name;
            $productAux['price'] = $product->price;
            $productResult [] = $productAux;
        }
        return $productResult;
    }
}
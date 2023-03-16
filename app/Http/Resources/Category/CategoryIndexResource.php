<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryIndexResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $categories    = $this->resource;
        $categoryAux    = [];
        $categoryResult = [];
      
        foreach($categories as $category) {
            $categoryAux['id']   = $category->id;
            $categoryAux['name'] = $category->name;
            $categoryAux['description'] = $category->description;
            $categoryResult [] = $categoryAux;
        }
        return $categoryResult;
    }
}
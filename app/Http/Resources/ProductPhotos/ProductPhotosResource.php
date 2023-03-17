<?php

namespace App\Http\Resources\ProductPhotos;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPhotosResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $photos   = $this->resource;
        $photoAux = [];
        $photoResult = [];

        foreach ($photos as $photo) {
            $photoAux['id']    = $photo->id;
            $photoAux['photo'] = $photo->image;
            $photoResult[] = $photoAux;
        }
        return $photoResult;
    }
}

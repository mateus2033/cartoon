<?php

namespace App\Http\Resources\Stock;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'        =>$this->id,
            'value_min' =>$this->stock_min,
            'value_max' =>$this->stock_max,
            'value_current' =>$this->stock_current,
        ];
    }
}
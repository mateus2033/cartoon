<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [ 
            'id'     => $this->id,
            'street' => $this->street, 
            'number' => $this->number,
            'city'   => $this->city, 
            'state'  => $this->state, 
            'postalCode' => $this->postalCode, 
            'user'       => $this->user_id, 
        ];
    }
}
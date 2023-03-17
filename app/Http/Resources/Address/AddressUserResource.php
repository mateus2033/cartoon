<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressUserResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $addresses     = $this->resource;
        $addressAux    = [];
        $addressResult = [];

        foreach ($addresses as $address) {
            $addressAux['id']     = $address->id;
            $addressAux['street'] = $address->street;
            $addressAux['number'] = $address->number;
            $addressAux['city'] = $address->city;
            $addressAux['state'] = $address->state;
            $addressAux['postalCode'] = $address->postalCode;
            $addressAux['user_id'] = $address->user_id;
            $addressResult[] = $addressAux;
        }

        return $addressResult;
    }
}

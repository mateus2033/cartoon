<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {  

        $addresses     = $this->address;
        $addressAux    = [];
        $addressResult = [];

        foreach($addresses as $address) {
            $addressAux['id']     = $address->id;
            $addressAux['street'] = $address->street;
            $addressAux['number'] = $address->number;
            $addressAux['city'] = $address->city;
            $addressAux['state'] = $address->state;
            $addressAux['postalCode'] = $address->postalCode;
            $addressResult [] = $addressAux;
        }

        return [ 
            'id'        => $this->id,
            'name'      => $this->name,
            'lastName'  => $this->lastName,
            'cpf'       => $this->cpf,
            'dataBirth' => $this->dataBirth,
            'cellphone' => $this->cellphone,
            'image'     => $this->image,
            'email'     => $this->email,
            'address'   => $addressResult
        ];
    }
}

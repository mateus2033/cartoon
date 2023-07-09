<?php 

namespace App\Http\Resources\BankData;

use Illuminate\Http\Resources\Json\JsonResource;

class BankDataShowResource extends JsonResource
{

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
            'card'   => $this->number_card,
            'agency' => $this->number_agency,
            'security' => $this->number_security,
            'bank'  => $this->bank_id,
        ];
    }
}

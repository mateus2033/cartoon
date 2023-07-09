<?php

namespace App\Http\Resources\BankData;

use Illuminate\Http\Resources\Json\JsonResource;

class BankDataIndexResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $bankDatas     = $this->resource;
        $bankDataAux    = [];
        $bankDataResult = [];

        foreach ($bankDatas as $bankData) {
           
            $bankDataAux['id']       = $bankData->id;
            $bankDataAux['card']     = $bankData->number_card;
            $bankDataAux['agency']   = $bankData->number_agency;
            $bankDataAux['security'] = $bankData->number_security;
            $bankDataAux['bank']  = $bankData->bank_id;
            $bankDataResult[] = $bankDataAux;
        }
        return $bankDataResult;
    }
}

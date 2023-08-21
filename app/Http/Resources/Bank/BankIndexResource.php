<?php

namespace App\Http\Resources\Bank;

use Illuminate\Http\Resources\Json\JsonResource;

class BankIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $banks     = $this->resource;
        $bankAux    = [];
        $bankResult = [];

        foreach ($banks as $bank) {

            $bankAux['id']     = $bank->id;
            $bankAux['code']   = $bank->code;
            $bankAux['name']   = $bank->name;
            $bankAux['active'] = $bank->active;
            $bankResult[]      = $bankAux;
        }
        return $bankResult;
    }
}

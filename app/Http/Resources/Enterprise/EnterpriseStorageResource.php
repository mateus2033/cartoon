<?php 

namespace App\Http\Resources\Enterprise;

use Illuminate\Http\Resources\Json\JsonResource;

class EnterpriseStorageResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'fantasy_name' => $this->fantasy_name,
            'corporate_reason' => $this->corporate_reason,
            'state_registration' => $this->state_registration,
            'cnpj' => $this->cnpj,
            'municipal_registration' => $this->municipal_registration,
            'responsible' => $this->responsible,
            'foundation' => $this->foundation,
        ];
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'church_id' => $this->church_id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'birthday' => date('d/m/Y', strtotime($this->birthday)),
            'email' => $this->email,
            'cell_number' => $this->cell_number,
            'street_name' => $this->street_name,
            'city' => $this->city,
            'state' => $this->state,
            'church' => new ChurchResource($this->whenLoaded('church')),
        ];
    }
}

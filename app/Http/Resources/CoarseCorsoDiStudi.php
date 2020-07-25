<?php

namespace App\Http\Resources;

use App\Http\Resources\CoarseInsegnamento;
use Illuminate\Http\Resources\Json\JsonResource;

class CoarseCorsoDiStudi extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resourceToArray = parent::toArray($request); 

        $additionalCoarseInformations 
            = ['insegnamenti' => CoarseInsegnamento::collection($this->insegnamenti)]; 

        return array_merge($resourceToArray, $additionalCoarseInformations);
    }
}

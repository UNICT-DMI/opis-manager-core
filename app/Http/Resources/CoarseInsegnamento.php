<?php

namespace App\Http\Resources;

use App\Http\Resources\StructuredSchedeOpis;
use Illuminate\Http\Resources\Json\JsonResource;

class CoarseInsegnamento extends JsonResource
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

        $additionalCoarseInformations = 
            ['schedeopis' => new StructuredSchedeOpis($this->schedeOpis)]; 

        return array_merge($resourceToArray, $additionalCoarseInformations); 
    }
}

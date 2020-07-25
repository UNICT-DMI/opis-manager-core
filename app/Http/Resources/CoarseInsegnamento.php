<?php

namespace App\Http\Resources;

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

        $additionalCoarseInformations = ['schedeopis' => $this->schedeOpis]; 

        return array_merge($resourceToArray, $additionalCoarseInformations); 
    }
}

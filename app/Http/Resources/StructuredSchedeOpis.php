<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StructuredSchedeOpis extends JsonResource
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
        $domandeArray = json_decode($resourceToArray['domande'], true);

        // per incertezza sulla provenienza dei dati, viene convertito ogni elemento
        // ad un valore intero
        $domandeArray = array_map('intval', $domandeArray); 

        // le domande sono conservate in json contenente un array da 55 valori. 
        // Il client richiede che tale array sia diviso in 11 array da 5 valori
        // ciascuno. 
        $splittedArray = array_chunk($domandeArray, 5);

        $resourceToArray['domande'] = \json_encode($splittedArray);  
        return $resourceToArray;
    }
}

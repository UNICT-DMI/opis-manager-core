<?php

namespace App\Traits; 

use Illuminate\Database\Eloquent\Model;

trait OpisModelFinder
{
    /**
     * Trova un modello opis attraverso l'id fornito dal sito 
     * dell'unict (unict_id) e l'anno accademico di riferimento.
     * Se non viene trovato alcun modello, scatena una exception
     * http not-found che ritornerà una response con status code
     * 404 al client.  
     *
     * @param  string $unictId
     * @param  string $annoAccademico
     * @return Model
     */
    public static function opisFindOrFail(string $unictId, string $annoAccademico): Model
    {
        $model = self::where('unict_id', $unictId)
            ->where('anno_accademico', $annoAccademico)
            ->first(); 

        if ($model === null) 
            abort(404); 
        
        return $model; 
    }
}
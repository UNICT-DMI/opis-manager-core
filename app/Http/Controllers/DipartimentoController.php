<?php

namespace App\Http\Controllers;

use App\Models\Dipartimento;
use Illuminate\Http\Request;
use App\Http\Requests\YearRequest;
use Symfony\Component\HttpFoundation\Response;

class DipartimentoController extends Controller
{
        
    /**
     * Ritorna la lista dei dipartimenti relativa all'anno accademico
     * passato come parametro. 
     *
     * @param  Request  $request
     * @return Response
     */
    public function index (YearRequest $request): Response 
    {
        $dipartimenti = Dipartimento::where('anno_accademico', $request->anno_accademico)->get();  

        return response()->json($dipartimenti); 
    }
    
    /**
     * Ritorna la lista di corsi di studi associati al dipartimento
     * referenziato dall'unict id e dall'anno accademico passato come
     * parametro. 
     *
     * @param  mixed $unictId
     * @param  mixed $request
     * @return Response
     */
    public function corsiDiStudi (int $unictId, YearRequest $request): Response
    {
        $dip = Dipartimento::opisFindOrFail($unictId, $request->anno_accademico); 

        return response()->json($dip->corsiDiStudi); 
    }

    /**
     * Ritorna la lista di corsi di studi associati al dipartimento
     * referenziato attraverso l'id del modello, che tramite i meccanismi
     * di type hinting e D.I. viene convertito in una istanza di Dipartimento.  
     *
     * @param  Dipartimento $dipartimento
     * @return Response
     */
    public function corsiDiStudiWithID (Dipartimento $dipartimento): Response
    {
        return response()->json($dipartimento->corsiDiStudi); 
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\CorsoDiStudi;
use Illuminate\Http\Request;
use App\Http\Requests\YearRequest;
use Symfony\Component\HttpFoundation\Response;

class CorsoDiStudiController extends Controller
{    
    /**
     * Ritorna la lista dei corsi di studi relativa all'anno 
     * accademico passato come parametro. 
     *
     * @param  mixed $request
     * @return void
     */
    public function index(YearRequest $request): Response
    {
        $cds = CorsoDiStudi::where('anno_accademico', $request->anno_accademico)->get(); 

        return response()->json($cds); 
    }
    
    /**
     * Ritorna la lista degli insegnamenti relativa al corso
     * di studi identificato dall'unict-id e dall'anno 
     * accademico passato come parametro.      
     * 
     * @param  int $unictId
     * @param  Request $request
     * @return Response
     */
    public function insegnamenti(int $unictId, YearRequest $request): Response
    {
        $cds = CorsoDiStudi::opisFindOrFail($unictId, $request->anno_accademico); 

        return response()->json($cds->insegnamenti); 
    }

    /**
     * Ritorna la lista di insegnamenti associati al corso di studi
     * referenziato attraverso l'id del modello, che tramite i meccanismi
     * di type hinting e D.I. viene convertito in una istanza di Dipartimento. 
     *      
     * @param  CorsoDiStudi $cds
     * @return Response
     */
    public function insegnamentiWithID(CorsoDiStudi $cds): Response
    {
        return response()->json($cds->insegnamenti); 
    }
}

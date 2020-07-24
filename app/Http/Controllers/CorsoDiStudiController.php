<?php

namespace App\Http\Controllers;

use App\Models\CorsoDiStudi;
use Illuminate\Http\Request;
use App\Http\Requests\YearRequest;
use App\Http\Requests\UpdatePesiCds;
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
     * Ritorna la lista completa dei corsi di studi salvati 
     * nella base di dati. 
     * 
     * @return Response
     */
    public function all (): Response
    {
        return response()->json(CorsoDiStudi::all()); 
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
     * di type hinting e D.I. viene convertito in una istanza di CorsoDiStudi. 
     *      
     * @param  CorsoDiStudi $cds
     * @return Response
     */
    public function insegnamentiWithID(CorsoDiStudi $cds): Response
    {
        return response()->json($cds->insegnamenti); 
    }
    
    /**
     * updatePesi
     *
     * @param  CorsoDiStudi $cds
     * @param  UpdatePesiCds $request
     * @return void
     */
    public function updatePesi(CorsoDiStudi $cds, UpdatePesiCds $request): void 
    {
        $cds->pesi_domande = $request->pesi; 
        $cds->save(); 
    }
}

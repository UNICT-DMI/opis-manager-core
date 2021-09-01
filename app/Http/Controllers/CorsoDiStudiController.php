<?php

namespace App\Http\Controllers;

use App\Models\CorsoDiStudi;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePesi;
use App\Http\Requests\YearRequest;
use App\Http\Requests\UpdateCorsoDiStudi;
use App\Http\Resources\CoarseCorsoDiStudi;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\JsonResource;

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
     * Dato un CDS in input, dare in output tutte le schede opis di 
     * tutti gli insegnamenti del CDS di tutti gli anni accademici
     * - issue #11
     * 
     * @param  string $unictId
     * @return JsonResource
     */
    public function searchSchedeOpisUsingUnictId (string $unictId): JsonResource 
    {
        $cdsCollection = CorsoDiStudi::where('unict_id', $unictId)->get(); 

        return CoarseCorsoDiStudi::collection($cdsCollection); 
    }

    /**
     * Ritorna la lista degli insegnamenti relativa al corso
     * di studi identificato dall'unict-id e dall'anno 
     * accademico passato come parametro.      
     * 
     * @param  string $unictId
     * @param  Request $request
     * @return Response
     */
    public function insegnamenti(string $unictId, YearRequest $request): Response
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
     * Aggiorna i valori (aggiornabili) del corso di studi. 
     *
     * @param  UpdateCorsoDiStudi $request
     * @return void
     */
    public function update (CorsoDiStudi $cds, UpdateCorsoDiStudi $request): void 
    {
        $updatedFields = $request->only(CorsoDiStudi::getUpdateableFields()); 

        $cds->update($updatedFields); 
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Insegnamento;
use Illuminate\Http\Request;
use App\Http\Requests\YearRequest;
use App\Http\Requests\InsegnamentoRequest;
use Symfony\Component\HttpFoundation\Response;

class InsegnamentoController extends Controller
{    
    /**
     * Ritorna la lista di insegnamenti relativa all'anno 
     * accademico passato come parametro. 
     *
     * @param  Request $request
     * @return Response
     */
    public function index(YearRequest $request): Response
    {
        $insegnamenti = Insegnamento::where('anno_accademico', $request->anno_accademico)->get();  

        return response()->json($insegnamenti);  
    }
    
    /**
     * Ritorna la lista completa dei insegnamenti salvati 
     * nella base di dati. 
     * 
     * @return Response
     */
    public function all (): Response
    {
        return response()->json(Insegnamento::all()); 
    }

    /**
     * Ritorna una lista di insegnamenti identificati dai dati passati
     * come parametri nella richiesta (codice gomp, anno accademico, 
     * canale (facoltativo), modulo (facoltativo)). All'interno di ogni 
     * elemento della lista, vi sono le relative schede opis associate. 
     * Si preferisca una indicizzazione con gli id progressivi per 
     * identificare con precisione gli insegnamenti. 
     *
     * @param  int      $codiceGomp
     * @param  Request  $request
     * @return Response
     */
    public function schedeOpis(int $codiceGomp, InsegnamentoRequest $request): Response 
    {
        $insegnamenti = Insegnamento::where('codice_gomp', $codiceGomp)
            ->where('anno_accademico', $request->anno_accademico); 

        if ($request->has('id_modulo'))
            $insegnamenti->where('id_modulo', $request->id_modulo); 

        if ($request->has('canale'))
            $insegnamenti->where('id_modulo', $request->canale); 

        return response()->json($insegnamenti->with('schedeOpis')->get()); 
    }

    /**
     * Ritorna la lista di schede opis associate all'insegnamento
     * referenziato attraverso l'id del modello, che tramite i meccanismi
     * di type hinting e D.I. viene convertito in una istanza di Insegnamento. 
     *
     * @param  Insegnamento $insegnamento
     * @return Response
     */
    public function schedeOpisWithID(Insegnamento $insegnamento): Response 
    {
        return response()->json($insegnamento->schedeOpis); 
    }
}

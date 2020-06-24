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
}

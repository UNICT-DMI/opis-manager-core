<?php

namespace App\Http\Controllers;

use App\Models\Domanda;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateDomandaRequest;
use Symfony\Component\HttpFoundation\Response;

class DomandeController extends Controller
{    
    /**
     * Ritorna la lista di tutte le domande con i relativi
     * gruppi di appartenenza e pesi standard. 
     *
     * @return JsonResponse
     */
    public function index(): Response
    {
        return response()->json(Domanda::all()); 
    }
    
    /**
     * Aggiorna il peso o/e il gruppo di una domanda. 
     *
     * @param  Domanda $domanda
     * @param  UpdateDomandaRequest $request
     * @return void
     */
    public function update(Domanda $domanda, UpdateDomandaRequest $request): void
    {
        $domanda->update($request->all()); 
    }
}

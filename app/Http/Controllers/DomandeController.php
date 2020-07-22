<?php

namespace App\Http\Controllers;

use App\Models\Domanda;
use Illuminate\Http\Request;
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
}

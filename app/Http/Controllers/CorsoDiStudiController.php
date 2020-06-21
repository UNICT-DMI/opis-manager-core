<?php

namespace App\Http\Controllers;

use App\Models\CorsoDiStudi;
use Illuminate\Http\Request;
use App\Http\Requests\YearRequest;

class CorsoDiStudiController extends Controller
{    
    /**
     * Ritorna la lista dei corsi di studi relativa all'anno 
     * accademico passato come parametro. 
     *
     * @param  mixed $request
     * @return void
     */
    public function index(YearRequest $request)
    {
        $cds = CorsoDiStudi::where('anno_accademico', $request->anno_accademico)->get(); 

        return response()->json($cds); 
    }
}

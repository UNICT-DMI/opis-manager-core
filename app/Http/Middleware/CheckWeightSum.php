<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Domanda;
use Symfony\Component\HttpFoundation\Response;

class CheckWeightSum
{
    private $error = ['error' => 'la somma dei pesi del gruppo e\' maggiore di 1.']; 
        
    /**
     * Ritorna la somma dei pesi delle domande appartenenti al 
     * gruppo passato come parametro. Il gruppo può anche assumere
     * valore null. 
     *
     * @param  string $group
     * @return float
     */
    private function getSumByGroup(?string $gruppo): float
    {
        return Domanda::where('gruppo', $gruppo)
            ->sum('peso_standard'); 
    } 

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domanda = $request->route('domanda');

        $pesoIntrodotto = $request->has('peso_standard') 
            ? $request->peso_standard
            : $domanda->peso_standard; 

        $gruppo = $request->has('gruppo') 
            ? $request->gruppo 
            : $domanda->gruppo;     
            
        $sommaPesi = $this->getSumByGroup($gruppo);  
        
        // se la domanda è contenuta nel gruppo di destinazione, allora
        // è necessario sottrarre il suo precedente peso. 
        if (Domanda::where('gruppo', $gruppo)->find($domanda->id)) {
            $sommaPesi -= $domanda->peso_standard; 
        }

        return $sommaPesi + $pesoIntrodotto > 1
            ? response()->json($this->error, Response::HTTP_BAD_REQUEST)
            : $next($request);
    }
}

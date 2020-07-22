<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckWeightSum
{
    private $error = 'la somma dei pesi del gruppo è maggiore di 1.'; 

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sumOfWeights = Domanda::where('group', $request->gruppo)
            ->sum('peso_standard');       

        if ($sumOfWeights + $request->peso_standard > 1) {
            
            return response()->json(
                ['error' => $this->error], 
                Response::HTTP_BAD_REQUEST
            ); 
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{        
    /**
     * Registra un utente nel database
     *
     * @param  SignupRequest $request
     * @return Response
     */
    public function signup (SignupRequest $request): Response
    {
        $response = User::create($request->all()); 

        return response()->json([]); 
    }
}

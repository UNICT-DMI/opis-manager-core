<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{    
    public function signup (SignupRequest $request): Response
    {
        User::create($request->all()); 

        return response()->json([]); 
    }
}

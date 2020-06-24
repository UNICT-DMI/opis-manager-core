<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{  
    
    public function __costruct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup']]); 
    }

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
    
    /**
     * Autentica l'utente e ritorna il token jwt
     *
     * @param  mixed $request
     * @return Response
     */
    public function login (LoginRequest $request): Response 
    {
        $credentials = $request->only(['email', 'password']); 

        if (! $token = Auth::attempt($credentials)) {
            return response()->json([], Response::HTTP_UNAUTHORIZED); 
        }

        return $this->respondWithToken($token);
    }

    /** 
     * Refresh a token.
     *
     * @return Response
     */
    public function refresh(): Response
    {
        return $this->respondWithToken(auth()->refresh());
    }

   /**
    * Log the user out (invalidate the token)
    *
    * @return Response
    */
   public function logout(): Response
   {
       auth()->logout(); 

       return response()->json([], Response::HTTP_OK); 
   }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return Response 
     */
    protected function respondWithToken($token): Response 
    {
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * 60
        ]);
    }
}

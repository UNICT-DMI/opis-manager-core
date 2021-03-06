<?php

namespace Tests\Feature\Controllers\Auth;

use App\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationControllerTest extends TestCase
{   
    use RefreshDatabase; 

    /** @test */
    public function user_can_singup_with_valid_data(): void 
    {
        $response = $this->post('api/auth/signup', [
            'nome' => 'Mario', 
            'cognome' => 'Rossi',
            'email' => 'example@example.com', 
            'password' => 'Password33', 
            'password_confirmation' => 'Password33'
        ]); 

        $this->assertTrue(User::where('email', 'example@example.com')->exists()); 
        $response->assertStatus(200); 
    }

    /** @test */
    public function user_cannot_signup_with_already_taken_email(): void
    {
        $user = factory(User::class)->create(); 

        $response = $this->json('POST', 'api/auth/signup', [
            'nome' => 'Mario', 
            'cognome' => 'Rossi',
            'email' => $user->email, 
            'password' => 'Password33', 
            'password_confirmation' => 'Password33'
        ]); 

        $response->assertStatus(422); 
    }

    /** @test */
    public function user_cannot_signup_with_weak_password(): void
    {
        $response = $this->json('POST', 'api/auth/signup', [
            'nome' => 'Mario', 
            'cognome' => 'Rossi',
            'email' => 'example@example.com', 
            'password' => 'weakpassword', 
            'password_confirmation' => 'weakpassword'
        ]); 

        $response->assertStatus(422); 
    }

    /** @test */
    public function user_password_is_hashed_in_database(): void
    {
        $response = $this->post('api/auth/signup', [
            'nome' => 'Mario', 
            'cognome' => 'Rossi',
            'email' => 'example@example.com', 
            'password' => 'Password33', 
            'password_confirmation' => 'Password33'
        ]); 

        $newUser = User::where('email', 'example@example.com')->first(); 
        $this->assertTrue(Hash::check('Password33', $newUser->password)); 
    }

    /** @test */
    public function user_can_retrieve_jwt_with_credentials(): void
    {
        $user = factory(User::class)->create(); 

        $response = $this->call('POST', '/api/auth/login', [
            'email'     => $user->email, 
            'password'  => 'Password33' // factory std password
        ]);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']); 
    }

    /** @test */
    public function user_cannot_retrieve_jwt_with_invalid_credentials(): void
    {
        $user = factory(User::class)->create(); 

        $response = $this->call('POST', '/api/auth/login', [
            'email'     => $user->email, 
            'password'  => 'Password22' // not the factory std password
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED); 
    }

    /** @test */
    public function user_can_refresh_token(): void
    {
        $user = factory(User::class)->create(); 

        $token = auth()->login($user);

        $response = $this->call('POST', '/api/auth/refresh', ['token' => $token]);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /** @test */
    public function token_is_invalidated_after_refresh(): void
    {
        $user = factory(User::class)->create(); 

        $token = auth()->login($user); 
        
        $response = $this->call('POST', '/api/auth/refresh', ['token' => $token]);

        $this->assertFalse(JWTAuth::check($token)); 
    }

    /** @test */
    public function user_can_logout(): void
    {
        $user = factory(User::class)->create(); 

        $token = auth()->login($user); 

        $response = $this->call('POST', '/api/auth/logout', ['token' => $token]);

        $response->assertStatus(200); 
    }

    /** @test */
    public function token_is_invalidated_after_logout(): void
    {
        $user = factory(User::class)->create(); 

        $token = auth()->login($user); 

        $response = $this->call('POST', '/api/auth/logout', ['token' => $token]);

        $this->assertFalse(JWTAuth::check($token));
    }

    /** @test */
    public function authenticated_user_can_retrieve_its_informations(): void
    {
        $user = factory(User::class)->create();

        $token = auth()->login($user); 

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])
            ->json('GET', '/api/auth/me');

        $response->assertStatus(200)
            ->assertJson($user->toArray()); 
    }
}

<?php

namespace Tests\Feature\Controllers\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
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
}

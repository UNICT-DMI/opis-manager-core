<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Domanda;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomandeControllerTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_get_a_list_of_domande(): void
    {
        $this->seed(\StandardWeightSeeder::class);
        $response = $this->json('GET',  '/api/v2/domande');

        $response->assertStatus(200); 
        $response->assertJson(Domanda::all()->toArray());  
    }
}

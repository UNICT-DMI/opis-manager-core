<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Dipartimento;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DipartimentoControllerTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_return_dipartimenti_as_a_json(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);

        $response = $this->json('GET',  '/api/v2/dipartimento', ['anno_accademico' => '2017/2018']);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_return_dipartimento_corsi_di_studi(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 

        $dipartimento = Dipartimento::first(); 

        $response = $this->json(
            'GET',  
            '/api/v2/dipartimento/' . $dipartimento->unict_id . '/cds', 
            ['anno_accademico' => '2017/2018']
        );

        $response->assertStatus(200);
    }

}

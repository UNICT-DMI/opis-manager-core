<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\CorsoDiStudi;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CorsoDiStudiControllerTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Json d'errore ritornato nel caso in cui (ove è richiesto)
     * manchi l'anno accademico. 
     * 
     * @var array 
     */
    private $missingAnnoAccademicoJson = [
        'message' => 'The given data was invalid.', 
        'errors' => ['anno_accademico' => ['The anno accademico field is required.']]
    ];  

    /** @test */
    public function can_return_corsi_di_studi_as_a_json(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);

        $response = $this->json(
            'GET',
            '/api/v2/cds', 
            ['anno_accademico' => '2017/2018']
        );

        $response->assertStatus(200);
        $response->assertJson(CorsoDiStudi::where('anno_accademico', '2017/2018')->get()->toArray()); 
    }

    /** @test */
    public function cannot_return_corsi_di_studi_without_anno_accademico(): void
    {
        $response = $response = $this->json('GET', '/api/v2/cds');
        
        $response->assertStatus(422); 
        $response->assertJson($this->missingAnnoAccademicoJson); 
    }

    /** @test */
    public function can_return_corso_di_studi_insegnamenti(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\InsegnamentoTableSeeder::class);
        
        $cds = CorsoDiStudi::first(); 

        $response = $this->json(
            'GET',
            '/api/v2/cds/' . $cds->unict_id . '/insegnamenti', 
            ['anno_accademico' => '2017/2018']
        );

        $response->assertStatus(200);
        $response->assertJson($cds->insegnamenti->toArray()); 
    }

    public function cannot_return_corso_di_studi_insegnamenti_without_anno_accademico(): void
    {
        $response = $response = $this->json('GET', '/api/v2/cds/1/insegnamenti');
        
        $response->assertStatus(422); 
        $response->assertJson($this->missingAnnoAccademicoJson); 
    }

    /** @test */
    public function can_return_corso_di_studi_insegnamenti_with_id(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\InsegnamentoTableSeeder::class);
        
        $cds = CorsoDiStudi::first(); 

        $response = $this->json('GET', '/api/v2/cds/with-id/' . $cds->id . '/insegnamenti');

        $response->assertStatus(200);
        $response->assertJson($cds->insegnamenti->toArray()); 
    }
}

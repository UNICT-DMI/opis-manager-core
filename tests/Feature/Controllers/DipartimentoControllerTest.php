<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Dipartimento;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DipartimentoControllerTest extends TestCase
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
    public function can_return_dipartimenti_as_a_json(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);

        $response = $this->json('GET',  '/api/v2/dipartimento', ['anno_accademico' => '2017/2018']);

        $response->assertStatus(200);
        $response->assertJson(Dipartimento::where('anno_accademico', '2017/2018')->get()->toArray()); 
    }

    /** @test */
    public function cannot_return_dipartimenti_without_anno_accademico(): void
    {
        $response = $this->json('GET', '/api/v2/dipartimento');
        
        $response->assertStatus(422); 
        $response->assertJson($this->missingAnnoAccademicoJson); 
    }

    /** @test */
    public function can_return_the_full_list_of_dipartimenti(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $response = $this->json('GET',  '/api/v2/dipartimento/all');

        $response->assertStatus(200); 
        $response->assertJson(Dipartimento::all()->toArray()); 
    }

    /** @test */
    public function can_return_dipartimento_corsi_di_studi(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 
        $this->seed(\CorsoDiStudiTableSeeder::class); 

        $dipartimento = Dipartimento::first(); 

        $response = $this->json(
            'GET',  
            '/api/v2/dipartimento/' . $dipartimento->unict_id . '/cds', 
            ['anno_accademico' => '2017/2018']
        );

        $response->assertStatus(200);
        $response->assertJson($dipartimento->corsiDiStudi->toArray()); 
    }

    /** @test */
    public function cannot_return_dipartimento_corsi_di_studi_without_anno_accademico(): void
    {
        $response = $response = $this->json('GET', '/api/v2/dipartimento/1/cds');
        
        $response->assertStatus(422); 
        $response->assertJson($this->missingAnnoAccademicoJson); 
    }

    /** @test */
    public function can_return_dipartimento_corsi_di_studi_using_id(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 
        $this->seed(\CorsoDiStudiTableSeeder::class); 

        $dipartimento = Dipartimento::first(); 

        $response = $this->json('GET', '/api/v2/dipartimento/with-id/' . $dipartimento->id . '/cds');

        $response->assertStatus(200);
        $response->assertJson($dipartimento->corsiDiStudi->toArray()); 
    }
}

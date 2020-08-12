<?php

namespace Tests\Feature\Controllers;

use App\User;
use Tests\TestCase;
use App\Models\CorsoDiStudi;
use App\Http\Resources\CoarseCorsoDiStudi;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CorsoDiStudiControllerTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Json di pesi di domande valido d'esempio. 
     * 
     * @var string 
     */
    private $validSampleJson = <<<JSON
        [
            {"id":1,  "peso":0.7,"gruppo":"V1"},
            {"id":2,  "peso":0.3,"gruppo":"V1"},
            {"id":4,  "peso":0.1,"gruppo":"V2"},
            {"id":5,  "peso":0.3,"gruppo":"V2"},
            {"id":9,  "peso":0.3,"gruppo":"V2"},
            {"id":10, "peso":0.3,"gruppo":"V2"},
            {"id":3,  "peso":0.1,"gruppo":"V3"},
            {"id":6,  "peso":0.5,"gruppo":"V3"},
            {"id":7,  "peso":0.4,"gruppo":"V3"}
        ]
    JSON; 

    /**
     * Json di pesi di domande contenente gruppi inconsistenti. 
     * 
     * @var string 
     */
    private $sumGreaterThanOneSampleJson = <<<JSON
        [
            {"id":1,  "peso":0.9,"gruppo":"V1"},
            {"id":2,  "peso":0.9,"gruppo":"V1"},
            {"id":4,  "peso":0.9,"gruppo":"V2"},
            {"id":5,  "peso":0.3,"gruppo":"V2"},
            {"id":9,  "peso":1.3,"gruppo":"V2"},
            {"id":10, "peso":0.3,"gruppo":"V2"},
            {"id":3,  "peso":0.1,"gruppo":"V3"},
            {"id":6,  "peso":2.5,"gruppo":"V3"},
            {"id":7,  "peso":0.4,"gruppo":"V3"}
        ]
    JSON; 

    /**
     * Json di pesi di domande che non rispetta lo schema imposto. 
     * 
     * @var string 
     */
    private $invalidJsonSchemaSampleJson = <<<JSON
        [
            {"id":1,  "gruppo":"V1"},
            {"id":2,  "peso":0.3,"gruppo":"V1"},
            {"id":4,  "peso":0.1,"gruppo":"V2"},
            {"id":5,  "peso":0.3,"gruppo":"V2"},
            {"id":9,  "peso":0.3,"gruppo":"V2"},
            {"id":10, "peso":0.3,},
            {"id":3,  "peso":0.1,"gruppo":"V3"},
            {"id":6,  "gruppo":"V3"},
            {"peso":0.4,"gruppo":"V3"}
        ]
    JSON; 

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
    public function can_return_the_full_list_of_corsi_di_studi(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $response = $this->json('GET',  '/api/v2/cds/all');

        $response->assertStatus(200); 
        $response->assertJson(CorsoDiStudi::all()->toArray()); 
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

    /** @test */
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

    /** @test */
    public function can_edit_pesi_domande_into_cds_with_valid_json(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);

        $cds = CorsoDiStudi::first(); 
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json(
            'PUT', 
            '/api/v2/cds/with-id/' . $cds->id . "/pesi",
            ['pesi' => $this->validSampleJson]    
        ); 

        $response->assertOk();
    }

    /**
     * I gruppi che contengono domande tale che la somma dei pesi sia maggiore
     * o uguale ad 1 sono da considerare inconsistenti. Pertanto, non dovrebbe 
     * essere salvato un json che contenga gruppi inconsistenti. 
     * 
     * @test
    */
    public function cannot_edit_pesi_domande_into_cds_with_greater_than_one_sum(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);

        $cds = CorsoDiStudi::first(); 
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json(
            'PUT', 
            '/api/v2/cds/with-id/' . $cds->id . "/pesi",
            ['pesi' => $this->sumGreaterThanOneSampleJson]    
        ); 

        $response->assertStatus(422);
    }

    /**
     * il parametro json passato alla api dovrebbe rispettare un rigido schema 
     * che indica la composizione dell'array di pesi. Se lo schema non è rispettato, 
     * allora l'api rifiuta l'update. 
     * 
     * @test
     */
    public function cannot_edit_pesi_domande_into_cds_with_an_invalid_json(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);

        $cds = CorsoDiStudi::first(); 
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json(
            'PUT', 
            '/api/v2/cds/with-id/' . $cds->id . "/pesi",
            ['pesi' => $this->invalidJsonSchemaSampleJson]    
        ); 

        $response->assertStatus(422);
    }

    /** @test */
    public function can_update_pesi_domande_if_logged_in(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $user   = factory(User::class)->create();
        $token  = auth()->login($user); 
        $cds    = CorsoDiStudi::first(); 
        $route  = '/api/v2/cds/with-id/' . $cds->id . '/pesi'; 

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('PUT', $route, ['pesi' => $this->validSampleJson]); 

        $response->assertOk();
    }

    /** @test */
    public function cannot_update_pesi_domande_without_being_logged_in(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $user = factory(User::class)->create();
        $cds = CorsoDiStudi::first(); 

        $response = $this->json(
            'PUT', 
            '/api/v2/cds/with-id/' . $cds->id . "/pesi",
            ['pesi' => $this->validSampleJson]    
        ); 

        $response->assertUnauthorized();
    }

    /** @test */
    public function can_get_all_schede_opis_relative_to_cds_corresponding_to_an_unict_id(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\SchedeOpisTableSeeder::class); 

        $randomCds = CorsoDiStudi::first(); 

        $response = $this->json('GET', 'api/v2/cds/coarse/'. $randomCds->unict_id . '/schedeopis'); 

        $cdsCollection = CorsoDiStudi::where('unict_id', $randomCds->unict_id)->get(); 

        $correctDataToRetrieve = json_decode(CoarseCorsoDiStudi::collection($cdsCollection)->toJson(), true); 

        $response->assertOk(); 
        $response->assertJson($correctDataToRetrieve); 
    }
}

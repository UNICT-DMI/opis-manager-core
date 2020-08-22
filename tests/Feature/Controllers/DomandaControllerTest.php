<?php

namespace Tests\Feature\Controllers;

use App\User;
use Tests\TestCase;
use App\Models\Domanda;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomandaControllerTest extends TestCase
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

    /** @test */
    public function can_get_a_list_of_domande(): void
    {
        $this->seed(\StandardWeightSeeder::class);
        $response = $this->json('GET',  '/api/v2/domande');

        $response->assertStatus(200); 
        $response->assertJson(Domanda::all()->toArray());  
    }

    /** @test */
    public function cannot_update_group_if_sum_become_more_than_1(): void 
    {
        $this->seed(\StandardWeightSeeder::class);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->json('PUT', '/api/v2/domande/1', ['gruppo' => 'V2']);

        $response->assertStatus(400); 
    }

    /** @test */
    public function can_update_group_with_a_sum_less_than_1(): void 
    {
        $this->seed(\StandardWeightSeeder::class);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->json('PUT', '/api/v2/domande/1', ['gruppo' => 'V4']);

        $response->assertOk(); 
    }

    /** @test */
    public function cannot_update_without_authentication(): void 
    {
        $this->seed(\StandardWeightSeeder::class);
        $user = factory(User::class)->create();

        $response = $this->json('PUT', '/api/v2/domande/1', ['gruppo' => 'V4']);
        $response->assertUnauthorized(); 
    }

    /** @test */
    public function can_update_if_authenticated(): void 
    {
        $this->seed(\StandardWeightSeeder::class);
        $user = factory(User::class)->create();
        $token = auth()->login($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('PUT', '/api/v2/domande/1', ['gruppo' => 'V4']);
        $response->assertOk(); 
    }

    /** @test */
    public function cannot_update_peso_standard_if_sum_is_more_than_1(): void
    {
        $this->seed(\StandardWeightSeeder::class);
        $user = factory(User::class)->create();

        $domanda = Domanda::first(); 
        $pesoGruppoDomanda = Domanda::where('gruppo', $domanda->gruppo)->sum('gruppo'); 
        $pesoGruppoDomanda -= $domanda->peso_standard; 
        $newPesoIrregolare = 1 - $pesoGruppoDomanda + 0.1;  

        $response = $this->actingAs($user)
            ->json('PUT', '/api/v2/domande/1', ['peso_standard' => $newPesoIrregolare]);
        $response->assertStatus(400); 
    }


    /** @test */
    public function can_update_peso_standard_if_sum_is_less_than_1(): void
    {
        $this->seed(\StandardWeightSeeder::class);
        $user = factory(User::class)->create();

        $domanda = Domanda::first(); 
        $newPesoRegolare = $domanda->peso_standard - 0.1;  

        $response = $this->actingAs($user)
            ->json('PUT', '/api/v2/domande/1', ['peso_standard' => $newPesoRegolare]);
        $response->assertOk(); 
    }

    /** @test */
    public function can_update_both_group_and_peso_standard(): void
    {
        $this->seed(\StandardWeightSeeder::class);
        $user = factory(User::class)->create();

        $domandaGruppoV1 = Domanda::where('gruppo', 'V1')->first();
        $domandaGruppoV2 = Domanda::where('gruppo', 'V2')->first(); 
        
        $newPesoStandard = $domandaGruppoV2->peso_standard; 
        $domandaGruppoV2->delete(); 

        $response = $this->actingAs($user)
            ->json('PUT', '/api/v2/domande/' . $domandaGruppoV1->id, [
            'peso_standard' => $newPesoStandard, 
            'gruppo' => 'V2'
        ]);

        $response->assertOk(); 
    }

    /** @test */
    public function can_update_all_domande_using_json(): void 
    {
        $this->seed(\StandardWeightSeeder::class);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->json('PUT', '/api/v2/domande', ['pesi' => $this->validSampleJson]); 
            
        $response->assertOk(); 
    }
}

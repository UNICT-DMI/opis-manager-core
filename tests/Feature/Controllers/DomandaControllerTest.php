<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Domanda;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomandaControllerTest extends TestCase
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

    /** @test */
    public function cannot_update_group_if_sum_become_more_than_1(): void 
    {
        $this->seed(\StandardWeightSeeder::class);
        $response = $this->json('PUT', '/api/v2/domande/1', ['gruppo' => 'V2']);

        $response->assertStatus(400); 
    }

    /** @test */
    public function can_update_group_with_a_sum_less_than_1(): void 
    {
        $this->seed(\StandardWeightSeeder::class);
        $response = $this->json('PUT', '/api/v2/domande/1', ['gruppo' => 'V4']);

        $response->assertOk(); 
    }

    /** @test */
    public function cannot_update_peso_standard_if_sum_is_more_than_1(): void
    {
        $this->seed(\StandardWeightSeeder::class);

        $domanda = Domanda::first(); 
        $pesoGruppoDomanda = Domanda::where('gruppo', $domanda->gruppo)->sum('gruppo'); 
        $pesoGruppoDomanda -= $domanda->peso_standard; 
        $newPesoIrregolare = 1 - $pesoGruppoDomanda + 0.1;  

        $response = $this->json('PUT', '/api/v2/domande/1', ['peso_standard' => $newPesoIrregolare]);
        $response->assertStatus(400); 
    }


    /** @test */
    public function can_update_peso_standard_if_sum_is_less_than_1(): void
    {
        $this->seed(\StandardWeightSeeder::class);

        $domanda = Domanda::first(); 
        $newPesoRegolare = $domanda->peso_standard - 0.1;  

        $response = $this->json('PUT', '/api/v2/domande/1', ['peso_standard' => $newPesoRegolare]);
        $response->assertOk(); 
    }

    /** @test */
    public function can_update_both_group_and_peso_standard(): void
    {
        $this->seed(\StandardWeightSeeder::class);

        $domandaGruppoV1 = Domanda::where('gruppo', 'V1')->first();
        $domandaGruppoV2 = Domanda::where('gruppo', 'V2')->first(); 
        
        $newPesoStandard = $domandaGruppoV2->peso_standard; 
        $domandaGruppoV2->delete(); 

        $response = $this->json('PUT', '/api/v2/domande/' . $domandaGruppoV1->id, [
            'peso_standard' => $newPesoStandard, 
            'gruppo' => 'V2'
        ]);

        $response->assertOk(); 
    }
}

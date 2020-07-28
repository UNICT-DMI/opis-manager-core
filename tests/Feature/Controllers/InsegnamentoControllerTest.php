<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\SchedeOpis;
use App\Models\Insegnamento;
use App\Http\Resources\CoarseInsegnamento;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InsegnamentoControllerTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_display_insegnamenti_as_a_json(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 
        $this->seed(\CorsoDiStudiTableSeeder::class); 
        $this->seed(\InsegnamentoTableSeeder::class); 

        $response = $this->json('GET', 'api/v2/insegnamento', ['anno_accademico' => '2017/2018']); 
        $response->assertJson(Insegnamento::where('anno_accademico', '2017/2018')->get()->toArray()); 
        $response->assertStatus(200); 
    }

    /** @test */
    public function cannot_display_insegnamenti_without_anno_accademico(): void 
    {
        $response = $this->json('GET', 'api/v2/insegnamento'); 

        $response->assertStatus(422); 
    }

    /** @test */
    public function can_return_the_full_list_of_insegnamenti(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 
        $this->seed(\CorsoDiStudiTableSeeder::class); 
        $this->seed(\InsegnamentoTableSeeder::class); 

        $response = $this->json('GET',  '/api/v2/insegnamento/all');

        $response->assertStatus(200); 
        $response->assertJson(Insegnamento::all()->toArray()); 
    }

    /** @test */
    public function can_display_insegnamento_schede_opis(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 
        $this->seed(\CorsoDiStudiTableSeeder::class); 
        $this->seed(\SchedeOpisTableSeeder::class); 

        $schedeOpis = SchedeOpis::first(); 
        $insegnamento = $schedeOpis->insegnamento; 

        $query = ['anno_accademico' => '2017/2018'];
        if ($insegnamento->id_modulo !== null)            
            array_merge($query, ['id_modulo' => $insegnamento->id_modulo]); 
        if ($insegnamento->canale !== null) 
            array_merge($query, ['canale' => $insegnamento->canale]); 

        $response = $this->json(
            'GET',
            'api/v2/insegnamento/'. $insegnamento->codice_gomp . '/schedeopis', 
            $query
        );

        $jsonResponse = Insegnamento::where('codice_gomp', $insegnamento->codice_gomp)
            ->where('anno_accademico', '2017/2018')
            ->where('id_modulo', $insegnamento->id_modulo)
            ->where('canale', $insegnamento->canale)
            ->with('schedeOpis')
            ->get()
            ->toArray();

        $response->assertStatus(200); 
        $response->assertJson($jsonResponse); 
    }

    /** @test */
    public function cannot_display_insegnamento_schede_opis_without_valid_parameters(): void 
    {
        $response = $this->json('GET', 'api/v2/insegnamento/1/schedeopis');

        $response->assertStatus(422);  
    }

    /** @test */
    public function can_display_insegnamento_schede_opis_with_id(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 
        $this->seed(\CorsoDiStudiTableSeeder::class); 
        $this->seed(\SchedeOpisTableSeeder::class); 

        $schedeOpis = SchedeOpis::first(); 
        $insegnamento = $schedeOpis->insegnamento; 
        
        $response = $this->json('GET', 'api/v2/insegnamento/with-id/'. $insegnamento->id .'/schedeopis');

        $response->assertStatus(200); 
        $response->assertJson($insegnamento->schedeOpis->toArray()); 
    }

    /**
     * Preambolo: prima di cimentarsi nella comprensione del test, leggere
     * lo scenario presentato nel seeder InsegnamentoCanaliSeeder. 
     * 
     * @test
    */
    public function can_get_coarse_data_using_unict_attributes(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 
        $this->seed(\InsegnamentoCanaliSeeder::class);         

        $insegnamento = Insegnamento::first(); 
        $route = 'api/v2/insegnamento/coarse/' . $insegnamento->codice_gomp . '/schedeopis'; 

        $response = $this->json('GET', $route, ['canale' => 'AL']); 

        $highLevelData = Insegnamento::where('codice_gomp', $insegnamento->codice_gomp)
            ->where('canale', 'AL')
            ->orWhere('canale', null)
            ->get(); 

        $deepLevelData = CoarseInsegnamento::collection($highLevelData); 
        $dataToArray = json_decode($deepLevelData->toJson(), true); 

        $response->assertOk(); 
        $response->assertJson($dataToArray); 
    }

    /**
     * Preambolo: prima di cimentarsi nella comprensione del test, leggere
     * lo scenario presentato nel seeder InsegnamentoCanaliSeeder. 
     * Si vuole provare che, considerato il canale AL del corso di architettura, 
     * non siano presenti anche i canali MZ, ma al più i corsi di anni precedenti
     * esenti dalla suddivisione in canali. 
     * 
     * @test
    */
    public function can_get_linear_history_of_insegnamento_using_coarse_api(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class); 
        $this->seed(\InsegnamentoCanaliSeeder::class);         

        $insegnamento = Insegnamento::first(); 
        $route = 'api/v2/insegnamento/coarse/' . $insegnamento->codice_gomp . '/schedeopis'; 

        $response = $this->json('GET', $route, ['canale' => 'AL']); 

        $numberOfMzChannels = $response->original
                ->map(function (CoarseInsegnamento $i) {return $i->canale;})
                ->filter(function (?string $canale) {return $canale == 'MZ';})
                ->count(); 

        $this->assertTrue($numberOfMzChannels == 0); 
    }
}

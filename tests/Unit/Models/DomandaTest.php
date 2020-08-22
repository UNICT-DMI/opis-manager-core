<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Domanda;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomandaTest extends TestCase 
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
    public function can_update_all_domande_with_a_valid_json(): void 
    {
        $this->seed(\StandardWeightSeeder::class);
        Domanda::updateAllUsingJson($this->validSampleJson); 

        $domandeFromDatabase = DB::select("SELECT id, peso_standard as peso, gruppo FROM domanda");
        $domandeFromDatabaseToArray = json_decode(json_encode($domandeFromDatabase), true); 
        $domandeFromRequestToArray = json_decode($this->validSampleJson, true); 

        $match = true; 

        // controlliamo se la configurazione conservata nella base di dati
        // rispecchia quella richiesta. 
        foreach ($domandeFromRequestToArray as $domandaFromRequest) {

            // otteniamo la stessa domanda dal database 
            $domandaFromDatabase = array_filter($domandeFromDatabaseToArray, 
                fn ($domanda) => $domanda['id'] == $domandaFromRequest['id']);

            // seleziono solo il primo elemento dall'array
            $domandaFromDatabase = reset($domandaFromDatabase); 
            $domandaNotExists = $domandaFromDatabase == null; 
            $pesiDomandeDoenstMatch = $domandaFromRequest['peso'] != $domandaFromDatabase['peso']; 
            $gruppiDomandeDoesntMatch = $domandaFromRequest['gruppo'] != $domandaFromDatabase['gruppo'];  

            if ($domandaNotExists || $pesiDomandeDoenstMatch || $gruppiDomandeDoesntMatch) {
                $match = false; 
                break; 
            }
        }

        $this->assertTrue($match);        
    }
}


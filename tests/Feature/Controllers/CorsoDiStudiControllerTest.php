<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\CorsoDiStudi;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CorsoDiStudiControllerTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_return_corsi_di_studi_as_a_json(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);

        $response = $this->json('GET',  '/api/v2/cds', ['anno_accademico' => '2017/2018']);

        $response->assertStatus(200);
        $response->assertJson(CorsoDiStudi::where('anno_accademico', '2017/2018')->get()->toArray()); 
    }
}

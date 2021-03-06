<?php

namespace Tests\Unit\Traits;

use Tests\TestCase;
use App\Models\CorsoDiStudi;
use App\Models\Dipartimento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OpisModelFinderTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_find_dipartimento_with_finder(): void
    {
        \factory(Dipartimento::class)->create(); 
        $conventional = Dipartimento::first(); 
    
        $withFinder = Dipartimento::opisFindOrFail(
            $conventional->unict_id, 
            $conventional->anno_accademico
        ); 

        $this->assertEquals($conventional->id, $withFinder->id);
    }

    /** @test */
    public function can_find_corso_di_studi_with_finder(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $conventional = CorsoDiStudi::first(); 
    
        $withFinder = CorsoDiStudi::opisFindOrFail(
            $conventional->unict_id, 
            $conventional->anno_accademico
        ); 

        $this->assertEquals($conventional->id, $withFinder->id);
    }
}

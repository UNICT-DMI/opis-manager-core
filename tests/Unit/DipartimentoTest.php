<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\CorsoDiStudi;
use App\Models\Dipartimento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DipartimentoTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_get_corsi_di_studi(): void 
    {
        $dipartimento = factory(Dipartimento::class)->create(); 
        $corsoDiStudi = factory(CorsoDiStudi::class)->create(); 
        $corsoDiStudi->id_dipartimento = $dipartimento->id; 
        $corsoDiStudi->save(); 

        $this->assertEquals($dipartimento->corsiDiStudi[0]->id, $corsoDiStudi->id); 
    }

    /** @test */
    public function corsi_di_studi_attribute_is_istance_of_collection(): void 
    {
        $dipartimento = factory(Dipartimento::class)->create(); 

        $this->assertTrue($dipartimento->corsiDiStudi instanceof Collection); 
    }

    /** @test */
    public function corsi_di_studi_elements_are_instance_of_corso_di_studi(): void 
    {
        $dipartimento = factory(Dipartimento::class)->create(); 
        $corsoDiStudi = factory(CorsoDiStudi::class)->create(); 
        $corsoDiStudi->id_dipartimento = $dipartimento->id; 
        $corsoDiStudi->save(); 

        $this->assertTrue($dipartimento->corsiDiStudi[0] instanceof CorsoDiStudi); 
    }

    /** @test */
    public function corsi_di_studi_function_is_istance_of_relation(): void 
    {
        $dipartimento = factory(Dipartimento::class)->create(); 

        $this->assertTrue($dipartimento->corsiDiStudi() instanceof HasMany); 
    }
}

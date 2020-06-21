<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\CorsoDiStudi;
use App\Models\Dipartimento;
use App\Models\Insegnamento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorsoDiStudiTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_get_dipartimento(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);

        $dipartimento = Dipartimento::first(); 
        $corsoDiStudi = CorsoDiStudi::first(); 

        $corsoDiStudi->id_dipartimento = $dipartimento->id; 
        $corsoDiStudi->save(); 

        $this->assertEquals($corsoDiStudi->id_dipartimento, $dipartimento->id); 
    }

    /** @test */
    public function dipartimento_attribute_is_instance_of_dipartimento(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->assertTrue(CorsoDiStudi::first()->dipartimento instanceof Dipartimento); 
    }

    /** @test */
    public function dipartimento_function_is_instance_of_belongsTo(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->assertTrue(CorsoDiStudi::first()->dipartimento() instanceof BelongsTo); 
    }

    /** @test */
    public function can_get_insegnamenti(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);

        $corsoDiStudi = CorsoDiStudi::first(); 
        $insegnamento = factory(Insegnamento::class)->create(); 

        $insegnamento->id_cds = $corsoDiStudi->id; 
        $insegnamento->save(); 

        $this->assertEquals($corsoDiStudi->insegnamenti[0]->id, $insegnamento->id); 
    }

    /** @test */
    public function insegnamenti_attribute_is_instance_of_collection(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        
        $this->assertTrue(CorsoDiStudi::first()->insegnamenti instanceof Collection); 
    }

    /** @test */
    public function insegnamenti_function_is_instance_of_has_many(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->assertTrue(CorsoDiStudi::first()->insegnamenti() instanceof HasMany); 
    }

    /** @test */
    public function insegnamenti_elements_are_instance_of_insegnamento(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\InsegnamentoTableSeeder::class);

        Insegnamento::first()->id_cds = CorsoDiStudi::first()->id; 
        $this->assertTrue(CorsoDiStudi::first()->insegnamenti[0] instanceof Insegnamento); 
    }
}

<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\SchedeOpis;
use App\Models\CorsoDiStudi;
use App\Models\Insegnamento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsegnamentoTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_get_corso_di_studi(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\InsegnamentoTableSeeder::class);

        $corsoDiStudi = CorsoDiStudi::first(); 
        $insegnamento = Insegnamento::first(); 

        $insegnamento->id_cds = $corsoDiStudi->id; 
        $insegnamento->save(); 

        $this->assertEquals($insegnamento->id_cds, $corsoDiStudi->id); 
    }

    /** @test */
    public function corso_di_studi_attribute_is_instance_of_corso_di_studi(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\InsegnamentoTableSeeder::class);
        $this->assertTrue(Insegnamento::first()->corsoDiStudi instanceof CorsoDiStudi); 
    }

    /** @test */
    public function corso_di_studi_function_is_instance_of_belongsTo(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\InsegnamentoTableSeeder::class);
        $this->assertTrue(Insegnamento::first()->corsoDiStudi() instanceof BelongsTo); 
    }

    /** @test */
    public function can_get_schede_opis(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\InsegnamentoTableSeeder::class);

        $insegnamento = Insegnamento::first(); 
        $schedeOpis = factory(SchedeOpis::class)->create(); 

        $schedeOpis->id_insegnamento = $insegnamento->id; 
        $schedeOpis->save(); 

        $this->assertEquals($insegnamento->schedeOpis[0]->id, $schedeOpis->id); 
    }

    /** @test */
    public function schede_opis_attribute_is_instance_of_collection(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\SchedeOpisTableSeeder::class);
        
        $this->assertTrue(Insegnamento::first()->schedeOpis instanceof Collection); 
    }

    /** @test */
    public function schede_opis_function_is_instance_of_has_many(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\SchedeOpisTableSeeder::class);
        
        $this->assertTrue(Insegnamento::first()->schedeOpis() instanceof HasMany); 
    }

    /** @test */
    public function insegnamenti_elements_are_instance_of_instagnamento(): void 
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\SchedeOpisTableSeeder::class);

        $this->assertTrue(Insegnamento::first()->schedeOpis[0] instanceof SchedeOpis); 
    }
}

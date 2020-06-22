<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\SchedeOpis;
use App\Models\Insegnamento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchedeOpisTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function can_get_insegnamento(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\SchedeOpisTableSeeder::class);

        $insegnamento = Insegnamento::first(); 
        $schedeOpis = SchedeOpis::first(); 

        $schedeOpis->id_insegnamento = $insegnamento->id; 
        $schedeOpis->save(); 

        $this->assertEquals($schedeOpis->id_insegnamento, $insegnamento->id); 
    }

    /** @test */
    public function insegnamento_attribute_is_instance_of_insegnamento(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\SchedeOpisTableSeeder::class);
        $this->assertTrue(SchedeOpis::first()->insegnamento instanceof Insegnamento); 
    }

    /** @test */
    public function corso_di_studi_function_is_instance_of_belongsTo(): void
    {
        $this->seed(\DipartimentoTableSeeder::class);
        $this->seed(\CorsoDiStudiTableSeeder::class);
        $this->seed(\SchedeOpisTableSeeder::class);
        $this->assertTrue(SchedeOpis::first()->insegnamento() instanceof BelongsTo); 
    }

}

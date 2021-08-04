<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\CorsoDiStudi;
use App\Models\Dipartimento;
use Faker\Generator as Faker;

$factory->define(CorsoDiStudi::class, function (Faker $faker) {
    
    $maxDipartimentoProgressive = Dipartimento::max('id'); 
    
    return [
        'unict_id'          => $faker->unique()->bothify('?##'), 
        'nome'              => 'Corso di ' . $faker->word, 
        'classe'            => $faker->bothify('?-##'), 
        'anno_accademico'   => '2017/2018', 
        'id_dipartimento'   => 1 + (rand() % $maxDipartimentoProgressive), 
    ];
});

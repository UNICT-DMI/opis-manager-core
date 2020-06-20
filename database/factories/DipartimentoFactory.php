<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Dipartimento;
use Faker\Generator as Faker;

$factory->define(Dipartimento::class, function (Faker $faker) {     

    return [
        'unict_id'          => Dipartimento::max('unict_id') + 1, 
        'nome'              => 'Dipartimento ' . $faker->word, 
        'anno_accademico'   => '2017/2018'
    ];
});

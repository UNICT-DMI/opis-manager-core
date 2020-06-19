<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\CorsoDiStudi;
use App\Models\Insegnamento;
use Faker\Generator as Faker;

$factory->define(Insegnamento::class, function (Faker $faker) {

    $maxCorsoDiStudiProgressive = CorsoDiStudi::max('id');

    return [
        'codice_gomp'       => 1 + Insegnamento::max('codice_gomp'),
        'nome'              => $faker->word,
        'anno_accademico'   => '2017/2018',
        'ssd'               => null,
        'anno'              => array(1, 2, 3)[rand() % 3],
        'semestre'          => array('I', 'II')[rand() % 2],
        'cfu'               => array(3, 6, 9, 12)[rand() % 4],
        'docente'           => $faker->lastName . ' ' . $faker->firstName,
        'canale'            => null,
        'modulo'            => null,
        'tipo'              => null,
        'assegn'            => null,
        'id_cds'            => 1 + (rand() % $maxCorsoDiStudiProgressive),
    ];
});

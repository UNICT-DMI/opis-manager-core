<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\CorsoDiStudi;
use App\Models\Insegnamento;
use Faker\Generator as Faker;

$factory->define(Insegnamento::class, function (Faker $faker) {

    $maxCorsoDiStudiProgressive = CorsoDiStudi::max('id');
    $idModulo = array($faker->numberBetween(2000, 10000), null)[rand() % 2];
    $nomeModulo = $idModulo != null ? 'laboratorio' : null;

    return [
        'codice_gomp'       => 1 + Insegnamento::max('codice_gomp'),
        'nome'              => $faker->word,
        'anno_accademico'   => '2017/2018',
        'ssd'               => null,
        'anno'              => array(1, 2, 3)[rand() % 3],
        'semestre'          => array('I', 'II')[rand() % 2],
        'cfu'               => array(3, 6, 9, 12)[rand() % 4],
        'docente'           => $faker->lastName . ' ' . $faker->firstName,
        'canale'            => array('AL', 'MZ', null)[rand() % 3],
        'id_modulo'         => $idModulo,
        'nome_modulo'       => $nomeModulo,
        'tipo'              => null,
        'assegn'            => null,
        'id_cds'            => 1 + (rand() % $maxCorsoDiStudiProgressive),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\SchedeOpis;
use App\Models\Insegnamento;
use Faker\Generator as Faker;

$factory->define(SchedeOpis::class, function (Faker $faker) {

    $totalSchedeOpis    = 20 + (rand() % 80); 
    $totalSchedeOpisNf  = 5 + (rand() % 15); 

    $questions = range(0, 44); 
    shuffle($questions); 
    $maxInsegnamentoProgressive = Insegnamento::max('id');

    return [
        'anno_accademico'   => '2017/2018', 
        'totale_schede'     => $totalSchedeOpis, 
        'totale_schede_nf'  => $totalSchedeOpisNf, 
        'femmine'           => rand() % $totalSchedeOpis, 
        'femmine_nf'        => rand() % $totalSchedeOpisNf, 
        'fc'                => rand() % $totalSchedeOpis, 
        'inatt'             => rand() % $totalSchedeOpis, 
        'inatt_nf'          => rand() % $totalSchedeOpisNf, 
        'eta'               => null, 
        'anno_iscr'         => null, 
        'num_studenti'      => null, 
        'ragg_uni'          => null, 
        'studio_gg'         => null, 
        'studio_tot'        => null, 
        'domande'           => json_encode($questions), 
        'domande_nf'        => json_encode(array_fill(0, 11, '')), 
        'motivo_nf'         => json_encode([]), 
        'sugg'              => json_encode([]), 
        'sugg_nf'           => json_encode([]), 
        'id_insegnamento'   => factory(Insegnamento::class)->create()->id, 
    ];
});

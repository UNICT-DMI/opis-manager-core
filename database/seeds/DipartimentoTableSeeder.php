<?php

use App\Models\Dipartimento;
use Illuminate\Database\Seeder;

class DipartimentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * La generazione di identificativi univoci unict_id
         * rende necessaria una esecuzione ciclica dalla factory. 
         * Questo poiché per la generazione di un record viene 
         * estrapolato il valore massimo di unict_id e incrementato
         * di uno (per renderlo univoco). Tuttavia, l'esecuzione
         * del factory è lazy e ottiene una sola volta il valore 
         * maggiore di unict_id e lo assegna a tutte le query 
         * da eseguire, rendendolo non solo non univoco, ma anche 
         * uguale per tutti i record aggiunti. 
         */

        for ($i = 0; $i < 10; $i++) 
            factory(Dipartimento::class, 1)->create(); 
    }
}

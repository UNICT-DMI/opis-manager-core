<?php

use App\Models\CorsoDiStudi;
use App\Models\Insegnamento;
use Illuminate\Database\Seeder;

class InsegnamentoCanaliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Ipotizziamo che il corso di Architettura degli elaboratori
         * non abbia suddivisione in canali dall'anno 2014/2015 all'anno
         * 2016/2017, dopodiché negli anni 2017/2018 e 2018/2019 la
         * numerosità degli studenti cresca a tal punto da dover suddividere
         * il corso nei canali AL ed MZ. 
         */

        /**
         * Per facilitare la creazione di dati di testing, utilizziamo 
         * un solo cds con un anno casuale che colleghi tutti gli insegnamenti. 
         * Tuttavia, questa scelta non influirà in alcun modo i risultati dei
         * test effettuati. 
         */
        $cds = factory(CorsoDiStudi::class)->create(); 

        /**
         * Raccogliamo le informazioni comuni del corso, in modo da poter
         * variare solamente le informazioni cruciali, quali anno accademico,
         * canale e docente. 
         */
        $basicInformations = [
            'codice_gomp'   => 11, 
            'nome'          => 'Architettura degli elaboratori', 
            'anno'          => '1', 
            'semestre'      => '2', 
            'cfu'           => '9', 
            'id_cds'        => $cds->id
        ]; 

        /** corso ADE 2014/2015 */
        Insegnamento::create(array_merge(
            $basicInformations, 
            ['anno_accademico' => '2014/2015', 'canale' => null, 'docente' => 'Scollo Giuseppe']
        )); 

        /** corso ADE 2015/2016 */
        Insegnamento::create(array_merge(
            $basicInformations, 
            ['anno_accademico' => '2015/2016', 'canale' => null, 'docente' => 'Scollo Giuseppe']
        )); 

        /** corso ADE 2016/2017 */
        Insegnamento::create(array_merge(
            $basicInformations, 
            ['anno_accademico' => '2016/2017', 'canale' => null, 'docente' => 'Scollo Giuseppe']
        )); 
        
        /** corso ADE 2017/2018 */
        Insegnamento::create(array_merge(
            $basicInformations, 
            ['anno_accademico' => '2017/2018', 'canale' => 'AL', 'docente' => 'Scollo Giuseppe']
        )); 

        Insegnamento::create(array_merge(
            $basicInformations, 
            ['anno_accademico' => '2017/2018', 'canale' => 'MZ', 'docente' => 'Napoli Christian']
        )); 

        /** corso ADE 2018/2019 */
        Insegnamento::create(array_merge(
            $basicInformations, 
            ['anno_accademico' => '2018/2019', 'canale' => 'AL', 'docente' => 'Scollo Giuseppe']
        )); 

        Insegnamento::create(array_merge(
            $basicInformations, 
            ['anno_accademico' => '2018/2019', 'canale' => 'MZ', 'docente' => 'Napoli Christian']
        )); 

    }
}

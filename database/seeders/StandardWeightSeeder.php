<?php

namespace Database\Seeders;

use App\Models\Domanda;
use Illuminate\Database\Seeder;

class StandardWeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domande = config('opis.domande'); 

        foreach ($domande as $domanda)
            Domanda::create($domanda); 
    }
}

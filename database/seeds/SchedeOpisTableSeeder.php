<?php

use App\Models\SchedeOpis;
use Illuminate\Database\Seeder;

class SchedeOpisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SchedeOpis::class, 200)->create(); 
    }
}

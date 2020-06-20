<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DipartimentoTableSeeder::class);
        $this->call(CorsoDiStudiTableSeeder::class);
        // $this->call(InsegnamentoTableSeeder::class);
        $this->call(SchedeOpisTableSeeder::class);
    }
}

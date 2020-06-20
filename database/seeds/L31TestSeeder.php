<?php

use Opis\Mocker\Mocker;
use Illuminate\Database\Seeder;

class L31TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mocker::getInstance()->run(); 
    }
}

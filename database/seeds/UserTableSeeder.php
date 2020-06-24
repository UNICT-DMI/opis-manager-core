<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** external testing user */
        User::create([
            'nome'      => 'Mario', 
            'cognome'   => 'Rossi',
            'email'     => 'example@example.com', 
            'password'  => Hash::make('Password33'), 
        ]); 

        factory(User::class, 5)->create(); 
    }
}

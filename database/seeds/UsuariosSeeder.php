<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::firstOrCreate(['email'=>'raislan@mail.com'],[
          'name'=>'raislan',
          'password'=>Hash::make('123456')
        ]);

        \App\User::firstOrCreate(['email'=>'sheila@mail.com'],[
          'name'=>'sheila',
          'password'=>Hash::make('123456')
        ]);



        echo "Usuários criados! \n";
    }
}

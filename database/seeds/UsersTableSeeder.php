<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
          'names' => 'Fausto',
          'first_surname' => 'Rivera',
          'second_surname' => 'Durón',
          'email' => 'fausto.radn@gmail.com',
          'password' => bcrypt('passwordf'),
          'role' => 'ADMIN'
        ]);

        User::create([
          'names' => 'Gabriel Raúl',
          'first_surname' => 'Monroy',
          'second_surname' => 'Walters',
          'email' => 'gabopmx5@gmail.com',
          'password' => bcrypt('passwordg'),
          'role' => 'ADMIN'
        ]);
    }
}

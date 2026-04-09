<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            BurgerSeeder::class
        ]);

        // User::factory()->create([
        //  'name' => 'Test User',
        //  'email' => 'test@example.com',
        //]);
        \App\Models\User::create([
           'name' => 'Dieumbe Thioukry',
            'email' => 'dieumbethioukry@gmail.com',
            'password' => bcrypt('password'),
            // On utilise bcrypt pour hacher le mot de passe
            'role' => 'admin',
        ]);
        \App\Models\User::create([
        'name' => 'Mbaye Ladiane',
            'email' => 'mbayeladiane@gmail.com',
            'password' => bcrypt('password'),
            // On utilise bcrypt pour hacher le mot de passe
            'role' => 'client',


        ]);

        }
}

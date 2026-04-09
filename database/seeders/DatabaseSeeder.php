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
            'name' => 'Dieumbe',
            'email' => 'dieumbe@test.com',
            'password' => bcrypt('password'),
            // On utilise bcrypt pour hacher le mot de passe
            'role' => 'admin',
        ]);




    }
}

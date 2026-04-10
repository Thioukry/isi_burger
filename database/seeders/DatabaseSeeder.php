<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            BurgerSeeder::class
        ]);
        User::create([
           'name' => 'Dieumbe Thioukry',
            'email' => 'dieumbethioukry@gmail.com',
            'password' => bcrypt('2002'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Mbaye Ladiane',
            'email' => 'mbayeladiane@gmail.com',
            'password' => bcrypt('1234'),
            'role' => 'client',
        ]);
    }
}

<?php
namespace Database\Seeders;
use App\Models\Burger;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BurgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Burger::truncate();
        Schema::enableForeignKeyConstraints();

        Burger::create(
            [
                'nom' => 'Dakar Cheese',
                'description' => 'Double cheddar, oignons confits',
                'prix' => 2500,
                'image'=>'burger4.jpg',
                'stock' => 10,
            ]);
        Burger::create([
                'nom' => 'ISI Classique',
                'description' => 'Le burger signature de l\'école',
                'prix' => 5000,
                'image' => 'burger5.jpg',
                'stock' => 30,
            ]);
        Burger::create([
                'nom' => 'Guediawaye Spicy',
                'description' => 'Sauce harissa, piment frais',
                'prix' => 2200,
                'image' => 'burger3.jpg',
                'stock' => 15,
            ]);
        Burger::create([
                'nom' => 'Chicken Crispy',
                'description' => 'Poulet frit, salade croquante',
                'prix' => 2800,
                'image' => 'burger15.jpg',
                'stock' => 20,
            ]);
        Burger::create([
                'nom' => 'Royal Bacon',
                'description' => 'Bacon fumé, œuf au plat',
                'prix' => 3000,
                'image' => 'burger9.jpg',
                 'stock' => 13,
            ]);
        Burger::create([
                'nom' => 'Veggie Delight',
                'description' => 'Steak de soja, légumes grillés',
                'prix' => 2400,
                'image' => 'burger1.jpg',
                'stock' => 8,
            ]);
        Burger::create([
                'nom' => 'Ocean Burger',
                'description' => 'Filet de poisson pané, sauce tartare',
                'prix' => 2600,
                'image' => 'burger12.jpg',
                 'stock' => 13,
            ]);
        Burger::create([
                'nom' => 'BBQ Cowboy',
                'description' => 'Sauce BBQ, oignons frits',
                'prix' => 2900,
                'image' => 'burger2.jpg',
                 'stock' => 17,
            ]);
        Burger::create([
                'nom' => 'Double Tower',
                'description' => 'Deux steaks hachés, double portion',
                'prix' => 3500,
                'image' => 'burger10.jpg',
                 'stock' => 25,
            ]);
        Burger::create([
                'nom' => 'Tropical Island',
                'description' => 'Ananas grillé, sauce aigre-douce',
                'prix' => 2700,
                'image' => 'burger7.jpg',
                'stock' => 16,
            ]);



    }
}




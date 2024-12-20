<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\product;
use Faker\Factory as Faker;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        $numberOfProducts = 15;

        for ($i = 0; $i < $numberOfProducts; $i++) {
            product::create([
                'nama' => $faker->word(),
                'deskripsi' => $faker->sentence(), 
                'harga' => $faker->randomFloat(2, 10, 1000),
                'gambar' => $faker->imageUrl(640, 480, 'products', true)
            ]);
        }
    }
}

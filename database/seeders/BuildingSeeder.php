<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        // Create 10 buildings with Russian addresses
        for ($i = 0; $i < 10; $i++) {
            Building::create([
                'address' => $faker->streetAddress,
                'latitude' => $faker->latitude(55.7, 55.8),  // Moscow area
                'longitude' => $faker->longitude(37.5, 37.7) // Moscow area
            ]);
        }
    }
}
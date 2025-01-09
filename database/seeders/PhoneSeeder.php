<?php

namespace Database\Seeders;

use App\Models\Phone;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PhoneSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        // Get all organizations
        $organizations = Organization::all();

        foreach ($organizations as $organization) {
            // Each organization gets 1-3 phone numbers
            $phoneCount = rand(1, 3);

            for ($i = 0; $i < $phoneCount; $i++) {
                Phone::create([
                    'organization_id' => $organization->id,
                    'phone_number' => $faker->phoneNumber
                ]);
            }
        }
    }
}
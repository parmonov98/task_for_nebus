<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrganizationSeeder extends Seeder
{
    private function generateOrganizationName($faker, $categoryId): string
    {
        $prefixes = ['ООО', 'ИП', 'АО', 'ЗАО'];
        $foodNames = ['Вкусняшка', 'Продукты', 'Еда', 'Лакомка', 'Гурман', 'Смак'];
        $serviceNames = ['Мастер', 'Сервис', 'Профи', 'Эксперт', 'Помощник'];
        $entertainmentNames = ['Отдых', 'Досуг', 'Радость', 'Веселье', 'Забава'];

        $prefix = $faker->randomElement($prefixes);

        // Food categories (1-6)
        if ($categoryId <= 6) {
            $name = $faker->randomElement($foodNames);
            return "{$prefix} \"{$name}\"";
        }
        // Service categories (7-12)
        else if ($categoryId <= 12) {
            $name = $faker->randomElement($serviceNames);
            $lastName = $faker->lastName;
            return "{$prefix} {$lastName} \"{$name}\"";
        }
        // Entertainment categories (13-18)
        else {
            $name = $faker->randomElement($entertainmentNames);
            return "{$prefix} \"{$name}\"";
        }
    }

    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        // First, ensure categories exist
        $mainCategories = Category::whereNull('parent_id')->get();

        foreach ($mainCategories as $mainCategory) {
            // Get child categories for this main category
            $childCategories = Category::where('parent_id', $mainCategory->id)->pluck('id')->toArray();

            if (empty($childCategories)) {
                continue;
            }

            // Create 10 organizations for each main category
            for ($i = 0; $i < 10; $i++) {
                // Select 1-2 random child categories
                $selectedCategories = array_rand(array_flip($childCategories), rand(1, min(2, count($childCategories))));
                if (!is_array($selectedCategories)) {
                    $selectedCategories = [$selectedCategories];
                }

                // Create organization
                $organization = Organization::create([
                    'name' => $this->generateOrganizationName($faker, $childCategories[0]),
                    'building_id' => $faker->numberBetween(1, 10), // Assuming 10 buildings
                ]);

                // Attach categories
                $organization->categories()->attach($selectedCategories);
            }
        }
    }
}
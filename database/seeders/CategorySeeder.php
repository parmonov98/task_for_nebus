<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Продукты питания
            ['name' => 'Продукты питания', 'parent_id' => null, 'level' => 1],
            ['name' => 'Молочная продукция', 'parent_id' => 1, 'level' => 2],
            ['name' => 'Мясная продукция', 'parent_id' => 1, 'level' => 2],
            ['name' => 'Хлебобулочные изделия', 'parent_id' => 1, 'level' => 2],

            // Услуги
            ['name' => 'Услуги', 'parent_id' => null, 'level' => 1],
            ['name' => 'Парикмахерские', 'parent_id' => 5, 'level' => 2],
            ['name' => 'Ремонт обуви', 'parent_id' => 5, 'level' => 2],
            ['name' => 'Химчистка', 'parent_id' => 5, 'level' => 2],

            // Развлечения
            ['name' => 'Развлечения', 'parent_id' => null, 'level' => 1],
            ['name' => 'Кинотеатры', 'parent_id' => 9, 'level' => 2],
            ['name' => 'Театры', 'parent_id' => 9, 'level' => 2],
            ['name' => 'Музеи', 'parent_id' => 9, 'level' => 2],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'sports',
            'gaming',
            'politics',
            'science',
            'finance',
            'careers'
        ];

        collect($categories)->each(function ($category) {
            Category::create([
                'name' => ucfirst($category)
            ]);
        });
    }
}

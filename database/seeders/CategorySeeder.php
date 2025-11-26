<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hair Salon',
                'slug' => 'hair-salon',
                'description' => 'Hair cutting, styling, coloring, and treatments',
                'icon' => '✂️',
            ],
            [
                'name' => 'Barbershop',
                'slug' => 'barbershop',
                'description' => 'Men\'s grooming, haircuts, and beard styling',
                'icon' => '💈',
            ],
            [
                'name' => 'Nail Salon',
                'slug' => 'nail-salon',
                'description' => 'Manicures, pedicures, and nail art',
                'icon' => '💅',
            ],
            [
                'name' => 'Spa & Massage',
                'slug' => 'spa-massage',
                'description' => 'Relaxation, massage therapy, and spa treatments',
                'icon' => '💆',
            ],
            [
                'name' => 'Beauty Salon',
                'slug' => 'beauty-salon',
                'description' => 'Makeup, facials, and beauty treatments',
                'icon' => '💄',
            ],
            [
                'name' => 'Eyebrows & Lashes',
                'slug' => 'eyebrows-lashes',
                'description' => 'Eyebrow shaping, tinting, and lash extensions',
                'icon' => '👁️',
            ],
            [
                'name' => 'Tattoo & Piercing',
                'slug' => 'tattoo-piercing',
                'description' => 'Tattoo art and body piercing services',
                'icon' => '🎨',
            ],
            [
                'name' => 'Wellness',
                'slug' => 'wellness',
                'description' => 'Holistic health, yoga, and wellness services',
                'icon' => '🧘',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}


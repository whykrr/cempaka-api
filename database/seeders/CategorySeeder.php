<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $create default category
        $category = [
            [
                'name' => 'Slider',
                'slug' => 'slider',
                'description' => 'Slider for Landing Page',
                'component' => null,
                'icon' => 'images',
                'is_display' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tentang',
                'slug' => 'tentang',
                'description' => 'landing page about us',
                'component' => null,
                'icon' => 'id-card',
                'is_display' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Unit Usaha',
                'slug' => 'unit-usaha',
                'description' => 'landing page our bussiness',
                'icon' => 'landmark',
                'component' => json_encode(
                    [
                        'content' => 'textarea',
                        'instagram' => 'text',
                        'whatsapp' => 'text',
                    ]
                ),
                'is_display' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Partner Bisnis',
                'slug' => 'partner-bisnis',
                'description' => 'landing page our partner',
                'component' => null,
                'icon' => 'handshake',
                'is_display' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blog & Artikel',
                'slug' => 'blog-artikel',
                'description' => 'page for blog and article',
                'component' => null,
                'icon' => 'newspaper',
                'is_display' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Media Sosial',
                'slug' => 'media-sosial',
                'description' => 'list of social media',
                'component' => null,
                'icon' => 'hashtag',
                'is_display' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        \App\Models\ContentCategory::insert($category);
    }
}

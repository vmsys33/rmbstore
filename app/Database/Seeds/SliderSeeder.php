<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Welcome to RMB Store',
                'subtitle' => 'Discover amazing products at the best prices',
                'image' => 'assets/frontend/images/slider1.jpg',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'New Collection',
                'subtitle' => 'Latest trends and styles for every occasion',
                'image' => 'assets/frontend/images/slider2.jpg',
                'button_text' => 'Explore Collection',
                'button_url' => '/products',
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Quality Products',
                'subtitle' => 'Best prices guaranteed with premium quality',
                'image' => 'assets/frontend/images/slider3.jpg',
                'button_text' => 'Learn More',
                'button_url' => '/about',
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('sliders')->insertBatch($data);
    }
}

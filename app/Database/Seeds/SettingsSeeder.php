<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'store_name' => 'RMB Store',
            'store_logo' => null,
            'navicon' => null,
            'admin_name' => 'Admin User',
            'admin_email' => 'admin@example.com',
            'about_us' => 'Welcome to RMB Store - Your trusted online shopping destination.',
            'owner_photo' => null,
            'contact_phone' => '+63 912 345 6789',
            'contact_address' => '123 Main Street, Metro Manila, Philippines',
            'social_facebook' => 'https://facebook.com/rmbstore',
            'social_instagram' => 'https://instagram.com/rmbstore',
            'social_twitter' => 'https://twitter.com/rmbstore',
            'currency' => 'PHP',
            'tax_rate' => 0.00,
            'shipping_cost' => 0.00,
            'business_hours' => 'Monday - Friday: 9:00 AM - 6:00 PM',
            'timezone' => 'Asia/Manila',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('settings')->insert($data);
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ChatbotSeeder extends Seeder
{
    public function run()
    {
        $this->call('ChatbotQASeeder');
        $this->call('ChatbotProductsSeeder');
    }
}
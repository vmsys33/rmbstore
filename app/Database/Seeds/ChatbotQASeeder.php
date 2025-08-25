<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ChatbotQASeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'question' => 'What are your store hours?',
                'answer' => 'Our store is open Monday to Friday from 9am to 6pm, Saturday from 10am to 4pm, and we are closed on Sundays.',
                'keywords' => 'hours,open,time,schedule,operation',
                'category' => 'general',
                'priority' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'question' => 'Do you offer free shipping?',
                'answer' => 'Yes, we offer free shipping on all orders over $50. Orders under $50 have a flat shipping rate of $5.99.',
                'keywords' => 'shipping,free,delivery,cost',
                'category' => 'shipping',
                'priority' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'question' => 'What is your return policy?',
                'answer' => 'We accept returns within 30 days of purchase. Items must be unused and in original packaging. Please contact customer service to initiate a return.',
                'keywords' => 'return,policy,refund,exchange',
                'category' => 'returns',
                'priority' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'question' => 'How can I track my order?',
                'answer' => 'You can track your order by logging into your account and viewing your order history. Alternatively, you can use the tracking number provided in your shipping confirmation email.',
                'keywords' => 'track,order,shipping,status,delivery',
                'category' => 'shipping',
                'priority' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'question' => 'Do you have a physical store?',
                'answer' => 'Yes, we have a physical store located at 123 Main Street, Anytown, USA. Feel free to visit us during our regular business hours.',
                'keywords' => 'store,location,physical,address',
                'category' => 'general',
                'priority' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data into the chatbot_qa table
        $this->db->table('chatbot_qa')->insertBatch($data);
    }
}
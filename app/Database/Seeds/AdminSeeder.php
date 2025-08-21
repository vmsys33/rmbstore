<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $adminModel = new \App\Models\AdminModel();
        
        // Create default admin if none exists
        $adminCount = $adminModel->countAllResults();
        
        if ($adminCount === 0) {
            $defaultAdmin = [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => 'admin123',
                'role' => 'super_admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $adminModel->insert($defaultAdmin);
            
            echo "Default admin created:\n";
            echo "Email: admin@example.com\n";
            echo "Password: admin123\n";
        } else {
            echo "Admin users already exist. Skipping seeder.\n";
        }
    }
}

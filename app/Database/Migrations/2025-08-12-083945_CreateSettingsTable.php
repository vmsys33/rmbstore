<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'store_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'store_logo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'admin_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'admin_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'about_us' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'owner_photo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'contact_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'contact_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'social_facebook' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'social_instagram' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'social_twitter' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'default' => 'USD',
            ],
            'tax_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
            ],
            'shipping_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'business_hours' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'timezone' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'UTC',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}

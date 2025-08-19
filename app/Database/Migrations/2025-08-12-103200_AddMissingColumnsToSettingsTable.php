<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingColumnsToSettingsTable extends Migration
{
    public function up()
    {
        // Check if currency column exists, if not add it
        if (!$this->db->fieldExists('currency', 'settings')) {
            $this->forge->addColumn('settings', [
                'currency' => [
                    'type' => 'VARCHAR',
                    'constraint' => 10,
                    'default' => 'USD',
                    'after' => 'social_twitter'
                ]
            ]);
        }

        // Check if tax_rate column exists, if not add it
        if (!$this->db->fieldExists('tax_rate', 'settings')) {
            $this->forge->addColumn('settings', [
                'tax_rate' => [
                    'type' => 'DECIMAL',
                    'constraint' => '5,2',
                    'default' => 0.00,
                    'after' => 'currency'
                ]
            ]);
        }

        // Check if shipping_cost column exists, if not add it
        if (!$this->db->fieldExists('shipping_cost', 'settings')) {
            $this->forge->addColumn('settings', [
                'shipping_cost' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0.00,
                    'after' => 'tax_rate'
                ]
            ]);
        }

        // Check if business_hours column exists, if not add it
        if (!$this->db->fieldExists('business_hours', 'settings')) {
            $this->forge->addColumn('settings', [
                'business_hours' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'shipping_cost'
                ]
            ]);
        }

        // Check if timezone column exists, if not add it
        if (!$this->db->fieldExists('timezone', 'settings')) {
            $this->forge->addColumn('settings', [
                'timezone' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'default' => 'UTC',
                    'after' => 'business_hours'
                ]
            ]);
        }
    }

    public function down()
    {
        // Remove the columns if they exist
        $this->forge->dropColumn('settings', ['currency', 'tax_rate', 'shipping_cost', 'business_hours', 'timezone']);
    }
}

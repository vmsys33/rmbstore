<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCashRegisterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'register_date' => [
                'type' => 'DATE',
                'unique' => true,
            ],
            'opening_balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'closing_balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'cash_in' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'cash_out' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'expected_balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'actual_balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'difference' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['open', 'closed'],
                'default'    => 'open',
            ],
            'opened_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'closed_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'opened_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'closed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('status');
        $this->forge->addKey('opened_by');
        $this->forge->addKey('closed_by');
        
        // Add foreign keys
        $this->forge->addForeignKey('opened_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('closed_by', 'users', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('cash_register');
    }

    public function down()
    {
        $this->forge->dropTable('cash_register');
    }
}

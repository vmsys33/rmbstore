<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryTransactionsTable extends Migration
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
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'transaction_type' => [
                'type'       => 'ENUM',
                'constraint' => ['sale', 'purchase', 'adjustment', 'return', 'damage', 'expiry'],
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'unit_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'total_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'reference_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'reference_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'transaction_date' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('product_id');
        $this->forge->addKey('transaction_type');
        $this->forge->addKey('transaction_date');
        $this->forge->addKey('reference_id');
        $this->forge->addKey('created_by');
        
        // Add foreign keys
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('inventory_transactions');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_transactions');
    }
}

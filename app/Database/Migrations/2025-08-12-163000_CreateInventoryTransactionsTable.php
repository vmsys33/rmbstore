<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryTransactionsTable extends Migration
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
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'inventory_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'transaction_type' => [
                'type' => 'ENUM',
                'constraint' => ['in', 'out', 'reserve', 'release', 'adjustment'],
                'null' => false,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'unit_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
                'default' => 0.00,
            ],
            'total_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
                'default' => 0.00,
            ],
            'reference_type' => [
                'type' => 'ENUM',
                'constraint' => ['sale', 'purchase', 'adjustment', 'transfer', 'return'],
                'null' => false,
            ],
            'reference_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'reference_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'batch_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'performed_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('product_id');
        $this->forge->addKey('inventory_id');
        $this->forge->addKey('transaction_type');
        $this->forge->addKey('reference_type');
        $this->forge->addKey('reference_id');
        $this->forge->addKey('batch_number');
        $this->forge->addKey('created_at');
        $this->forge->createTable('inventory_transactions');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_transactions');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClosingStatusToSales extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sales', [
            'closing_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'processed', 'closed'],
                'default' => 'pending',
                'null' => false,
                'after' => 'sale_status'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sales', 'closing_status');
    }
}

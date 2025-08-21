<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNaviconToSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('settings', [
            'navicon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'store_logo'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('settings', 'navicon');
    }
}

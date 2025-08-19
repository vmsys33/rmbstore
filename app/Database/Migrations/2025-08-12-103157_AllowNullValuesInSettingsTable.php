<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AllowNullValuesInSettingsTable extends Migration
{
    public function up()
    {
        // Modify store_name to allow null values
        $this->forge->modifyColumn('settings', [
            'store_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        // Modify admin_name to allow null values
        $this->forge->modifyColumn('settings', [
            'admin_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        // Modify admin_email to allow null values
        $this->forge->modifyColumn('settings', [
            'admin_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        // Revert store_name to not allow null values
        $this->forge->modifyColumn('settings', [
            'store_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);

        // Revert admin_name to not allow null values
        $this->forge->modifyColumn('settings', [
            'admin_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);

        // Revert admin_email to not allow null values
        $this->forge->modifyColumn('settings', [
            'admin_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryIconToCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('categories', [
            'category_icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'default' => 'fa fa-tag',
                'after' => 'description'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('categories', 'category_icon');
    }
}

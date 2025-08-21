<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageFieldsToProductsTable extends Migration
{
    public function up()
    {
        $fields = [
            'image_icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Product icon image path',
            ],
            'image_post' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Product post/featured image path',
            ],
        ];

        $this->forge->addColumn('products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', ['image_icon', 'image_post']);
    }
}

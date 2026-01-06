<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsCategory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cid' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cat_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('cid', true);
        $this->forge->createTable('posts_category', true, [
            'ENGINE' => 'InnoDB',
            'DEFAULT CHARACTER SET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('posts_category', true);
    }
}

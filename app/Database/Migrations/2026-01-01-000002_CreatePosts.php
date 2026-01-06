<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pid' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'p_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'p_descr' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cat_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('pid', true);
        $this->forge->addKey('cat_id');

        $this->forge->addForeignKey(
            'cat_id',
            'posts_category',
            'cid',
            'CASCADE',
            'CASCADE',
            'fk_post_cid'
        );

        $this->forge->createTable('posts', true, [
            'ENGINE' => 'InnoDB',
            'DEFAULT CHARACTER SET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        // Drop FK first to avoid constraint errors
        $this->forge->dropForeignKey('posts', 'fk_post_cid');
        $this->forge->dropTable('posts', true);
    }
}

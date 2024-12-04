<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => '255'],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => '255', 'empty' => false],
            'parent_id'   => ['type' => 'INT', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('parent_id', 'category', 'id');
        $this->forge->createTable('category');

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => '255'],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => '255'],
            'content'     => ['type' => 'TEXT'],
            'category_id' => ['type' => 'INT'],
            'created_at'  => ['type' => 'DATETIME'],
            'updated_at'  => ['type' => 'DATETIME']
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('category_id', 'category', 'id');
        $this->forge->createTable('article');
    }

    public function down()
    {
        $this->forge->dropTable('category');
        $this->forge->dropTable('article');
    }
}

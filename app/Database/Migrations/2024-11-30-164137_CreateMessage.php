<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMessage extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'first_name'  => ['type' => 'VARCHAR', 'constraint' => '255'],
            'last_name'   => ['type' => 'VARCHAR', 'constraint' => '255'],
            'email'       => ['type' => 'VARCHAR', 'constraint' => '255'],
            'message'     => ['type' => 'TEXT'],
            'created_at'  => ['type' => 'DATETIME'],
            'updated_at'  => ['type' => 'DATETIME'],
            'is_read'     => ['type' => 'BOOLEAN', 'default' => false],
            'is_answered' => ['type' => 'BOOLEAN', 'default' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('message');
    }

    public function down()
    {
        $this->forge->dropTable('message');
    }
}

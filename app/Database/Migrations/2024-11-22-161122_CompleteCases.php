<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CompleteCases extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'case_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'case_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'priority' => [
                'type'       => 'ENUM',
                'constraint' => ['High', 'Medium', 'Low'],
            ],
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('case_id', 'cases', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('complete_cases');
    }

    public function down()
    {
        $this->forge->dropTable('complete_cases');
    }
} 
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeblesNews extends Migration
{
  public function up()
  {
    $this->forge->addField(
      [
        'id' => [
          'type' => 'int',
          'constraint' => 11,
          'unsigned' => true,
          'auto_increment' => true,
        ],
        'title' => [
          'type' => 'varchar',
          'constraint' => '128',
          'null' => false,
        ],
        'slug' => [
          'type' => 'varchar',
          'constraint' => '128',
          'null' => false,
        ],
        'body' => [
          'type' => 'text',
          'null' => false,
        ],
      ]
    );
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('news');
  }

  public function down()
  {
    $this->forge->dropTable('news');
  }
}

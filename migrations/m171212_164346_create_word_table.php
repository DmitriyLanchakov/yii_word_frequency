<?php

use yii\db\Migration;

class m171212_164346_create_word_table extends Migration
{

    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('word', [
            'id'     => $this->primaryKey(),
            'input'  => $this->string()->notNull(),
            'output' => $this->string()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('word');
    }

}
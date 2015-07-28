<?php

use yii\db\Schema;
use mauriziocingolani\yii2fmwkphp\Migration;

class m150724_120014_create_entries_table extends Migration {

    public function up() {
        $this->createTable('entries', [
            'EntryID' => self::$primaryKey,
            'Created' => self::typeDate(true),
            'CreatedBy' => self::typeUnsignedInteger(),
            'ProjectID' => self::typeUnsignedInteger(true),
            'EntryText' => 'TEXT NOT NULL',
            'PRIMARY KEY (EntryID)',
                ], self::$tableOptions);
        $this->addForeignKey('fk_entries_createdby', 'entries', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_entries_project', 'entries', 'ProjectID', 'projects', 'ProjectID');
    }

    public function down() {
        $this->dropTable('entries');
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}

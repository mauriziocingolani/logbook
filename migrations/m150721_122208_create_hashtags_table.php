<?php

use yii\db\Schema;
use mauriziocingolani\yii2fmwkphp\Migration;

class m150721_122208_create_hashtags_table extends Migration {

    public function up() {
        $this->createTable('hashtags', [
            'HashtagID' => self::$primaryKey,
            'Created' => self::typeDate(),
            'CreatedBy' => self::typeUnsignedInteger(),
            'Updated' => self::typeDate(),
            'UpdatedBy' => self::typeUnsignedInteger(),
            'ProjectID' => self::typeUnsignedInteger(),
            'Name' => self::typeVarchar(255),
            'PRIMARY KEY (HashtagID)',
                ], self::$tableOptions);
        $this->addForeignKey('fk_hashtags_createdby', 'hashtags', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_hashtags_updatedby', 'hashtags', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_hashtags_project', 'hashtags', 'ProjectID', 'projects', 'ProjectID');
        $this->createIndex('unique_hashtags_name_project', 'hashtags', ['ProjectId', 'Name'], true);
        $this->createIndex('index_hashtags_name', 'hashtags', 'Name');
    }

    public function down() {
        $this->dropTable('hashtags');
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

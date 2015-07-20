<?php

use yii\db\Schema;
use mauriziocingolani\yii2fmwkphp\Migration;

class m150720_095340_create_projects_table extends Migration {

    public function up() {
        $this->createTable('projects', [
            'ProjectID' => self::$primaryKey,
            'Created' => Schema::TYPE_DATETIME . ' NULL',
            'CreatedBy' => Schema::TYPE_INTEGER . ' UNSIGNED NULL',
            'Updated' => Schema::TYPE_DATETIME . ' NULL',
            'UpdatedBy' => Schema::TYPE_INTEGER . ' UNSIGNED NULL',
            'Name' => self::typeVarchar(255, true),
            'Slug' => self::typeVarchar(255, true),
            'PRIMARY KEY (ProjectID)',
                ], self::$tableOptions);
        $this->createIndex('unique_projects_name', 'projects', 'Name', true);
        $this->createIndex('unique_projects_slug', 'projects', 'Slug', true);
        $this->addForeignKey('fk_projects_createdby', 'projects', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_projects_updatedby', 'projects', 'UpdatedBy', 'users', 'UserID');
    }

    public function down() {
        $this->dropTable('projects');
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

<?php

use yii\db\Schema;
use yii\db\Expression;
use mauriziocingolani\yii2fmwkphp\Migration;

class m150717_123418_create_roles_users_logins_tables extends Migration {

    public function up() {
        # ruoli
        $this->createTable('roles', [
            'RoleID' => self::$primaryKey,
            'Description' => self::typeVarchar(50, true),
            'PRIMARY KEY (RoleID)',
                ], self::$tableOptions);
        $this->createIndex('unique_description', 'roles', 'Description', true);
        $this->insert('roles', [ 'RoleID' => 1, 'Description' => 'Developer',]);
        $this->insert('roles', [ 'RoleID' => 2, 'Description' => 'Guest',]);
        # utenti
        $this->createTable('users', [
            'UserID' => self::$primaryKey,
            'Created' => Schema::TYPE_DATETIME . ' NULL',
            'CreatedBy' => Schema::TYPE_INTEGER . ' UNSIGNED NULL',
            'Updated' => Schema::TYPE_DATETIME . ' NULL',
            'UpdatedBy' => Schema::TYPE_INTEGER . ' UNSIGNED NULL',
            'RoleID' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'UserName' => Schema::TYPE_STRING,
            'Email' => Schema::TYPE_STRING . ' NOT NULL',
            'Password' => self::typeVarchar(152, true),
            'BanDateTime' => Schema::TYPE_DATETIME,
            'BanReason' => Schema::TYPE_TEXT,
            'PRIMARY KEY (UserID)',
                ], self::$tableOptions);
        $this->createIndex('unique_email', 'users', 'Email', true);
        $this->createIndex('unique_username', 'users', 'UserName', true);
        $this->addForeignKey('fk_createdby', 'users', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_updatedby', 'users', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_role', 'users', 'RoleID', 'roles', 'RoleID');
        $this->insert('users', [
            'Created' => new Expression('NOW()'),
            'RoleID' => 1,
            'UserName' => 'm_cingolani',
            'Email' => 'maurizio@mauriziocingolani.it',
            'Password' => base64_encode(Yii::$app->getSecurity()->encryptByKey('Antani1234@', Yii::$app->params['encryption_key'])),
        ]);
        # accessi
        $this->createTable('logins', [
            'LoginID' => self::$primaryKey,
            'SessionID' => self::typeChar(40, true),
            'UserID' => self::typeUnsignedInteger(),
            'UserName' => self::typeVarchar(255),
            'Login' => self::typeDate(true, true),
            'Logout' => self::typeDate(true),
            'IpAddress' => self::typeVarchar(15, true),
            'PRIMARY KEY (LoginID)'
                ], self::$tableOptions);
        $this->createIndex('sessionid', 'logins', 'SessionID');
        $this->addForeignKey('fk_user', 'logins', 'UserID', 'users', 'UserID');
    }

    public function down() {
        $this->dropTable('logins');
        $this->dropTable('users');
        $this->dropTable('roles');
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

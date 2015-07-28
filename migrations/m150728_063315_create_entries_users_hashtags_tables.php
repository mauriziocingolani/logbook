<?php

use yii\db\Schema;
use mauriziocingolani\yii2fmwkphp\Migration;

class m150728_063315_create_entries_users_hashtags_tables extends Migration {

    public function up() {
        # entries <-> users
        $this->createTable('entries_users', [
            'EntryUserID' => self::$primaryKey,
            'EntryID' => self::typeUnsignedInteger(true),
            'UserID' => self::typeUnsignedInteger(true),
            'PRIMARY KEY(EntryUserID)',
                ], self::$tableOptions);
        $this->createIndex('unique_entriesusers_entry_user', 'entries_users', ['EntryID', 'UserID'], true);
        $this->addForeignKey('fk_entriesusers_entry', 'entries_users', 'EntryID', 'entries', 'EntryID');
        $this->addForeignKey('fk_entriesusers_user', 'entries_users', 'UserID', 'users', 'UserID');
        # entries <-> hashtags
        $this->createTable('entries_hashtags', [
            'EntryHashtagID' => self::$primaryKey,
            'EntryID' => self::typeUnsignedInteger(true),
            'HashtagID' => self::typeUnsignedInteger(true),
            'PRIMARY KEY(EntryHashtagID)',
                ], self::$tableOptions);
        $this->createIndex('unique_entrieshashtags_entry_user', 'entries_hashtags', ['EntryID', 'HashtagID'], true);
        $this->addForeignKey('fk_entrieshashtags_entry', 'entries_hashtags', 'EntryID', 'entries', 'EntryID');
        $this->addForeignKey('fk_entrieshashtags_user', 'entries_hashtags', 'HashtagID', 'hashtags', 'HashtagID');
    }

    public function down() {
        $this->dropTable('entries_users');
        $this->dropTable('entries_hashtags');
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

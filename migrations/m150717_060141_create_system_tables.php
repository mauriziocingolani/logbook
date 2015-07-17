<?php

use yii\db\Schema;
use mauriziocingolani\yii2fmwkphp\Migration;

class m150717_060141_create_system_tables extends Migration {

    public function up() {
        # YiiSessions
        $this->createTable('YiiSessions', [
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER,
            'data' => 'LONGBLOB',
        ]);
        # YiiCache
        $this->createTable('YiiCache', [
            'id' => 'CHAR(128) NOT NULL PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER,
            'data' => 'LONGBLOB',
        ]);
    }

    public function down() {
        $this->dropTable('YiiSessions');
        $this->dropTable('YiiCache');
    }

}

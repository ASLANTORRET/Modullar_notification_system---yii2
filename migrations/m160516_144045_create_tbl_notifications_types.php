<?php

use yii\db\Migration;

class m160516_144045_create_tbl_notifications_types extends Migration
{
    public function up()
    {
        $this->createTable('tbl_notifications_types', [
            'id'         => $this->primaryKey(),
            'type'       => $this->string(30)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'nt_code'    => $this->string()->notNull()->unique()
        ]);

        $this->insert('tbl_notifications_types', [
            'type'       => 'Email',
            'created_at' => '1462861575',
            'updated_at' => '1462861575',
            'nt_code'    => 'email',
        ]);

        $this->insert('tbl_notifications_types', [
            'type'       => 'Browser',
            'created_at' => '1462862779',
            'updated_at' => '1462862779',
            'nt_code'    => 'browser',
        ]);

    }

    public function down()
    {
        $this->delete('tbl_notifications_types', ['id' => '2']);
        $this->delete('tbl_notifications_types', ['id' => '1']);

        $this->dropTable('tbl_notifications_types');
    }
}

<?php

use yii\db\Migration;

class m160516_144057_create_tbl_notifications extends Migration
{
    public function up()
    {
        $this->createTable('tbl_notifications', [
            'id' => $this->primaryKey(),
            'event_code' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'article' => $this->text()->notNull(),
            'user_from' => $this->integer(11)->notNull(),
            'user_to' => $this->integer(11),
            'nt_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->notNull()
        ]);

        // creates index for column `user_from`
        $this->createIndex(
            'idx-notifications-user_from',
            'tbl_notifications',
            'user_from'
        );

        // add foreign key for table `tbl_users`
        $this->addForeignKey(
            'fk-notifications-user_from',
            'tbl_notifications',
            'user_from',
            'tbl_users',
            'id',
            'CASCADE'
        );

        // creates index for column `user_to`
        $this->createIndex(
            'idx-notifications-user_to',
            'tbl_notifications',
            'user_to'
        );

        // add foreign key for table `tbl_users`
        $this->addForeignKey(
            'fk-notifications-user_to',
            'tbl_notifications',
            'user_to',
            'tbl_users',
            'id',
            'CASCADE'
        );

        // creates index for column `user_to`
        $this->createIndex(
            'idx-notifications-nt_id',
            'tbl_notifications',
            'nt_id'
        );

        // add foreign key for table `tbl_notifications_types`
        $this->addForeignKey(
            'fk-notifications-nt_id',
            'tbl_notifications',
            'nt_id',
            'tbl_notifications_types',
            'id',
            'CASCADE'
        );

        $this->insert('tbl_notifications', [
            'event_code' => 'Articles::EVENT_AFTER_CREATE',
            'title' => 'Создана новая статья1',
            'article' => "Создана новая статья '{title}'",
            'user_from' => 31,
            'user_to' => 32,
            'nt_id' => 2,
            'created_at' => '1462963081'
        ]);

        $this->insert('tbl_notifications', [
            'event_code' => 'Articles::EVENT_AFTER_CREATE',
            'title' => 'Создана новая статья',
            'article' => "Прочитайте новую  статью '{title}', где говорится о '{content}'. Дата создания: {created_at}",
            'user_from' => 32,
            'user_to' => null,
            'nt_id' => 1,
            'created_at' => '1463557320'
        ]);
    }

    public function down()
    {
        $this->delete('tbl_notifications_types', ['id' => '2']);
        $this->delete('tbl_notifications_types', ['id' => '1']);

        // drops foreign key for table `tbl_notifications`
        $this->dropForeignKey(
            'fk-notifications-user_from',
            'tbl_notifications'
        );

        // drops index for column `user_from`
        $this->dropIndex(
            'idx-notifications-user_from',
            'tbl_notifications'
        );

        // drops foreign key for table `tbl_notifications`
        $this->dropForeignKey(
            'fk-notifications-user_to',
            'tbl_notifications1'
        );

        // drops index for column `user_to`
        $this->dropIndex(
            'idx-notifications-user_to',
            'tbl_notifications'
        );

        // drops foreign key for table `tbl_notifications`
        $this->dropForeignKey(
            'fk-notifications-nt_id',
            'tbl_notifications'
        );

        // drops index for column `nt_id`
        $this->dropIndex(
            'idx-notifications-nt_id',
            'tbl_notifications'
        );

        $this->dropTable('tbl_notifications');
    }
}

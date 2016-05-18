<?php

use yii\db\Migration;

class m160516_144109_create_tbl_inbox extends Migration
{
    public function up()
    {
        $this->createTable('tbl_inbox', [

            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'article' => $this->text()->notNull(),
            'user_from' => $this->integer(11)->notNull(),
            'user_to' => $this->integer(11),
            'nt_id' => $this->integer(11)->notNull(),
            'is_new' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull()

        ]);

        // creates index for column `user_from`
        $this->createIndex(
            'idx-inbox-user_from',
            'tbl_inbox',
            'user_from'
        );

        // add foreign key for table `tbl_users`
        $this->addForeignKey(
            'fk-inbox-user_from',
            'tbl_inbox',
            'user_from',
            'tbl_users',
            'id',
            'CASCADE'
        );

        // creates index for column `user_to`
        $this->createIndex(
            'idx-inbox-user_to',
            'tbl_inbox',
            'user_to'
        );

        // add foreign key for table `tbl_users`
        $this->addForeignKey(
            'fk-inbox-user_to',
            'tbl_inbox',
            'user_to',
            'tbl_users',
            'id',
            'CASCADE'
        );

        // creates index for column `user_to`
        $this->createIndex(
            'idx-inbox-nt_id',
            'tbl_inbox',
            'nt_id'
        );

        // add foreign key for table `tbl_notifications_types`
        $this->addForeignKey(
            'fk-inbox-nt_id',
            'tbl_inbox',
            'nt_id',
            'tbl_notifications_types',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `tbl_inbox`
        $this->dropForeignKey(
            'fk-inbox-user_from',
            'tbl_inbox'
        );

        // drops index for column `nt_id`
        $this->dropIndex(
            'idx-inbox-user_from',
            'tbl_inbox'
        );

        // drops foreign key for table `tbl_inbox`
        $this->dropForeignKey(
            'fk-inbox-user_to',
            'tbl_inbox'
        );

        // drops index for column `user_to`
        $this->dropIndex(
            'idx-inbox-user_to',
            'tbl_inbox'
        );

        // drops foreign key for table `tbl_inbox`
        $this->dropForeignKey(
            'fk-inbox-nt_id',
            'tbl_inbox'
        );

        // drops index for column `nt_id`
        $this->dropIndex(
            'idx-inbox-nt_id',
            'tbl_inbox'
        );

        $this->dropTable('tbl_inbox');
    }
}

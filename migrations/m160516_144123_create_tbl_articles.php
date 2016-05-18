<?php

use yii\db\Migration;

class m160516_144123_create_tbl_articles extends Migration
{
    public function up()
    {
        $this->createTable('tbl_articles', [

            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'author_id' => $this->integer(11)->notNull()

        ]);

        // creates index for column `user_to`
        $this->createIndex(
            'idx-articles-author_id',
            'tbl_articles',
            'author_id'
        );

        // add foreign key for table `tbl_users`
        $this->addForeignKey(
            'fk-articles-author_id',
            'tbl_articles',
            'author_id',
            'tbl_users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `tbl_articles`
        $this->dropForeignKey(
            'fk-articles-author_id',
            'tbl_articles'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-articles-author_id',
            'tbl_articles'
        );

        $this->dropTable('tbl_articles');
    }
}

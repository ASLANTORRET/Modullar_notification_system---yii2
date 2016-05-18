<?php

use yii\db\Migration;

class m160516_144050_create_tbl_profile extends Migration
{
    public function up()
    {
        $this->createTable('tbl_profile', [
            'id'           => $this->primaryKey(),
            'user_id'      => $this->integer(11)->notNull(),
            'nt_id'        => $this->integer(11)->notNull(),
            'contact_data' => $this->string(100)->notNull()->unique(),
            'created_at'   => $this->integer(11)->notNull(),
            'updated_at'   => $this->integer(11)->notNull(),
        ]);

        // creates index for column `nt_id`
        $this->createIndex(
            'idx-profile-nt_id',
            'tbl_profile',
            'nt_id'
        );

        // add foreign key for table `tbl_notifications_types`
        $this->addForeignKey(
            'fk-profile-nt_id',
            'tbl_profile',
            'nt_id',
            'tbl_notifications_types',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-profile-user_id',
            'tbl_profile',
            'user_id'
        );

        // add foreign key for table `tbl_users`
        $this->addForeignKey(
            'fk-profile-user_id',
            'tbl_profile',
            'user_id',
            'tbl_users',
            'id',
            'CASCADE'
        );

        $this->insert('tbl_profile', [
            'user_id'      => '4',
            'nt_id'        => '1',
            'contact_data' => 'lostangels@mail.ru',
            'created_at'   => '1462961694',
            'updated_at'   => '1462961694',
        ]);

        $this->insert('tbl_profile', [
            'user_id'      => '31',
            'nt_id'        => '1',
            'contact_data' => 'aslan_08_kz@mail.ru',
            'created_at'   => '1463073663',
            'updated_at'   => '1463073663',
        ]);

        $this->insert('tbl_profile', [
            'user_id'      => '32',
            'nt_id'        => '2',
            'contact_data' => '32',
            'created_at'   => '1463211521',
            'updated_at'   => '1463211521',
        ]);
    }

    public function down()
    {
        $this->delete('tbl_profile', ['id' => '3']);
        $this->delete('tbl_profile', ['id' => '2']);
        $this->delete('tbl_profile', ['id' => '1']);

        // drops foreign key for table `tbl_profile`
        $this->dropForeignKey(
            'fk-profile-user_id',
            'tbl_profile'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-profile-user_id',
            'tbl_profile'
        );

        // drops foreign key for table `tbl_profile`
        $this->dropForeignKey(
            'fk-profile-nt_id',
            'tbl_profile'
        );

        // drops index for column `nt_id`
        $this->dropIndex(
            'idx-profile-nt_id',
            'tbl_profile'
        );

        $this->dropTable('tbl_profile');
    }
}

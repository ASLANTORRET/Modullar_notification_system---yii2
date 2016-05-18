<?php

use yii\db\Migration;

class m160516_143948_create_tbl_users extends Migration
{
    public function up()
    {
        $this->createTable('tbl_users', [

            'id'                => $this->primaryKey(),
            'username'          => $this->string()->notNull()->unique(),
            'email'             => $this->string()->notNull()->unique(),
            'password_hash'     => $this->string(60)->notNull(),
            'auth_key'          => $this->string(32)->notNull(),
            'confirmed_at'      => $this->integer(11)->defaultValue(null),
            'unconfirmed_email' => $this->string()->defaultValue(null),
            'blocked_at'        => $this->string()->defaultValue(null),
            'registration_ip'   => $this->string()->defaultValue(null),
            'created_at'        => $this->integer(11)->notNull(),
            'updated_at'        => $this->integer(11)->notNull(),
            'flags'             => $this->integer(11)->notNull()->defaultValue(0),

        ]);

        $this->insert('tbl_users', [
            'id'                => '4',
            'username'          => 'admin',
            'email'             => 'aslantorret#gmail.com',
            'password_hash'     => '$2y$12$SUUNQw0eZ28bpSZoHnSeX.ek4TD77MXTGzVQNywjZEvvy.khdX8au',
            'auth_key'          => '1juPqVPw_d__i4mzskMWMUBIEzXgzAA8',
            'confirmed_at'      => null,
            'unconfirmed_email' => null,
            'blocked_at'        => null,
            'registration_ip'   => '127.0.0.1',
            'created_at'        => '1462594431',
            'updated_at'        => '1462594431',
            'flags'             => 0,

        ]);

        $this->insert('tbl_users', [
            'id'                => '31',
            'username'          => 'manas',
            'email'             => 'manaselemesov@mail.ru',
            'password_hash'     => '$2y$10$5vf8vPeSNm7gGRXuuvsCxeuoPVzKDyQy7lEFsCK6OL.kV5bCeTKGO',
            'auth_key'          => 'h8uMuzAkcSvW0irtHbai1Y2DIs3yM8sG',
            'confirmed_at'      => '1463073663',
            'unconfirmed_email' => null,
            'blocked_at'        => null,
            'registration_ip'   => '127.0.0.1',
            'created_at'        => '1462594431',
            'updated_at'        => '1462594431',
            'flags'             => 0,

        ]);

        $this->insert('tbl_users', [
            'id'                => '32',
            'username'          => 'ermek',
            'email'             => 'ermek08@mail.ru',
            'password_hash'     => '$2y$10$iE01FrSgHtOfDw33InJ95uuDtJjsTX76.WJ3KbMI/qmM1cu4ItSUS',
            'auth_key'          => 'I7ihC-k5JRZaCJsP1C9q2K90q-eiISQ2',
            'confirmed_at'      => '1463211521',
            'unconfirmed_email' => null,
            'blocked_at'        => null,
            'registration_ip'   => '127.0.0.1',
            'created_at'        => '1463211521',
            'updated_at'        => '1463211521',
            'flags'             => 0,

        ]);
    }

    public function down()
    {
        $this->delete('tbl_profile', ['id' => '32']);
        $this->delete('tbl_profile', ['id' => '31']);
        $this->delete('tbl_profile', ['id' => '4']);

        $this->dropTable('tbl_users');
    }
}

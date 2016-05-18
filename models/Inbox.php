<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_inbox".
 *
 * @property integer $id
 * @property string $title
 * @property string $article
 * @property integer $user_from
 * @property integer $user_to
 * @property integer $nt_id
 * @property integer $is_new
 * @property integer $created_at
 *
 * @property NotificationsTypes $nt
 * @property Users $userTo
 * @property Users $userFrom
 */
class Inbox extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_inbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'article', 'user_from', 'nt_id', 'created_at'], 'required'],
            [['article'], 'string'],
            [['user_from', 'user_to', 'nt_id', 'is_new', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'article' => 'Текст',
            'user_from' => 'От',
            'user_to' => 'Кому (NULL - все пользователи)',
            'nt_id' => 'Тип уведомления (Notification type ID)',
            'is_new' => 'Прочитано ? (1 - да, 0 - нет)',
            'created_at' => 'Время создания (create_date)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNt()
    {
        return $this->hasOne(NotificationsTypes::className(), ['id' => 'nt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFrom()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_from']);
    }

    public function getNotifications($user_to){

        return self::find()->where(['user_to' => $user_to, 'nt_id' => 2])->all();
    }
}

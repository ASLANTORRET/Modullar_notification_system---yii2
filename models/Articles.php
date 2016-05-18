<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_articles".
 *
 * @property integer $id
 * @property integer $title
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property integer $author_id
 */
class Articles extends \yii\db\ActiveRecord
{

    const EVENT_AFTER_CREATE = 'afterCreate';

    public function init()
    {
        $this->on(self::EVENT_AFTER_CREATE, ['app\models\Notifications', 'callNotification'], 'Articles::EVENT_AFTER_CREATE');
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'created_at', 'updated_at', 'author_id'], 'required'],
            [['author_id'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at', 'author_id'], 'safe']
        ];
    }

    public function getConstants(){

        return $constants = get_defined_constants();

    }

    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'author_id']);
    }

    public function beforeSave($insert){

        if($insert){

            if($this->isNewRecord){
                $this->author_id = Yii::$app->user->getId();
                $this->created_at = $this->updated_at = time();
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Текст статьи',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата посл. редактирования',
            'author_id' => 'Автор статьи',
            'author.username' => 'Имя пользователя'
        ];
    }
}

<?php

namespace app\models;

use Yii;
use app\models\Scripts;
use yii\db\Query;
use ReflectionClass;
/**
 * This is the model class for table "tbl_notifications".
 *
 * @property integer $id
 * @property string $event_code
 * @property string $title
 * @property string $article
 * @property integer $user_from
 * @property integer $user_to
 * @property integer $nt_id
 * @property integer $created_at
 *
 * @property NotificationsTypes $nt
 * @property User $userFrom
 * @property User $userTo
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_code', 'title', 'article', 'user_from', 'nt_id', 'created_at'], 'required'],
            [['article'], 'string'],
            [['user_from', 'user_to', 'nt_id', 'created_at'], 'integer'],
            [['event_code', 'title'], 'string', 'max' => 255]
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
            'user_from' => 'От',
            'user_to' => 'Кому (NULL - все пользователи)',
            'nt_id' => 'Тип уведомления (Notification type ID)',
            'created_at' => 'Время создания (create_date)',
            'event_code' => 'Код события',
            'article' => 'Текст уведомления'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(User::className(), ['id' => 'user_to']);
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
    public function getUserFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'user_from']);
    }

    public static function getEventList( $default = null){

        $result = $excepts = [];

        if( isset(Yii::$app->params['notification_system']['class_to_attach'])){

            $excepts = Yii::$app->params['notification_system']['class_to_attach'];

        }

        foreach($excepts as $class_name){

                $class_path = 'app\models\\' . $class_name;

                if($refl = new ReflectionClass(new $class_path())){

                    $constants = array_keys($refl->getConstants());

                    foreach( $constants as $value){

                        if( strpos($value, 'EVENT') !== false ){

                            $result[ $class_name .  '::' . $value ] = $class_name . '::' . $value;

                        }
                    }
                }


        }

        return $default != null ? ([ null => $default] + $result) : $result;

    }

    public function callNotification($event){

        $event_code = $event->data;                         //event_code  - Код события
        $params = ['event_code' => $event_code];

        $notification = Notifications::find()->select('title, article, user_from, user_to, created_at, user_to, nt_id')->with([
            'userTo.profile' =>
                function($q) {
                    $q->select('contact_data, nt_id');
                },

            'nt'=>
                function($q){
                    $q->select('id, nt_code');
                }
            ]
        )->asArray(true)->where($params)->all();


        if($notification){

           $script = new Scripts();
           $script->setNotification($notification);
           $script->setEvent($event);
           $script->sendMessage();
        }


    }


    /*public function getUserFrom($params){
        return $this::find()->where($params)->all();
    }

    public function getUserTo($params){
        return $this::find()->where($params)->all();
    }*/

    public function beforeSave($insert){

        if($insert){
            if($this->isNewRecord){
                $this->created_at = time();
            }
        }

        return parent::beforeSave($insert);
    }

    /*public function afterFind($insert){

        if($insert){

            $this->nt_id = json_encode($this->nt_id);
            $this->created_at = time();

            return true;
        }
        else{
            return false;
        }
    }*/
}

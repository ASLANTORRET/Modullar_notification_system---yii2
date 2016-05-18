<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "tbl_notifications_types".
 *
 * @property integer $id
 * @property integer $type
 * @property string $created_at
 * @property string $updated_at
 * @property string $nt_code
 */
class NotificationsTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_notifications_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'created_at', 'updated_at', 'nt_code'], 'safe'],
            /*[['created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],*/
            [['type'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип уведомления',
            'created_at' => 'Дата создания (create_date)',
            'updated_at' => 'Дата посл. редактирования (last edit date)',
            'nt_code' => 'Notification code'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboxes()
    {
        return $this->hasMany(Inbox::className(), ['nt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::className(), ['nt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['nt_id' => 'id']);
    }

    public function beforeSave($insert){

        if($insert){
            $this->updated_at = time();
            $this->type = json_encode($insert->type);
            if($this->isNewRecord){
                $this->created_at = time();
            }
        }

        return parent::beforeSave(($insert));
    }
/*
    public function beforeSave($insert){

        if($insert){
            $this->updated_at = time();
            $this->type = json_encode($insert->type);
            if($this->isNewRecord){
                $this->created_at = time();
            }
        }

        return parent::beforeSave(($insert));
    }*/


    public static function listNotTypes(){

        return ArrayHelper::map( NotificationsTypes::find()->select('id,type')->asArray()->all(), 'id', 'type');

    }
}

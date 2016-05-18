<?php

namespace app\models;

use dektrium\user\models\Profile as BaseProfile;

/**
 * This is the model class for table "tbl_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $nt_id
 * @property string $contact_data
 * @property string $created_at
 * @property string $updated_at
 */
class Profile extends BaseProfile
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'nt_id', 'contact_data', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'nt_id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['contact_data'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'nt_id' => 'Тип уведомления',
            'contact_data' => 'Контактные данные (email,sms, telegram and etc.)',
            'created_at'   => 'Дата создания',
            'updated_at' => 'Дата посл. редактирования',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert){

        $this->updated_at = time();

        if($this->isNewRecord){
            $this->created_at = time();
        }

        return parent::beforeSave(($insert));
    }

}

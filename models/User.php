<?php

namespace app\models;

use Yii;
use \dektrium\user\models\User as BaseUser;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "tbl_users".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $confirmed_at
 * @property string $unconfirmed_email
 * @property integer $blocked_at
 * @property string $registration_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flags
 *
 * @property Articles[] $Articles
 * @property Inbox[] $Inboxes
 * @property Inbox[] $Inboxes0
 * @property Notifications[] $Notifications
 * @property Notifications[] $Notifications0
 * @property Profile[] $Profiles
 */

class User extends BaseUser
{

    /** @var Profile|null */
    private $_profile, $_profile2;


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboxes()
    {
        return $this->hasMany(Inbox::className(), ['user_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboxes0()
    {
        return $this->hasMany(Inbox::className(), ['user_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::className(), ['user_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications0()
    {
        return $this->hasMany(Notifications::className(), ['user_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }


    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if ($this->_profile == null && $this->_profile2 == null) {
                $this->_profile = Yii::createObject(Profile::className());
                $this->_profile2 = Yii::createObject(Profile::className());
            }
            $this->_profile->user_id = $this->getId();
            $this->_profile->nt_id = 1;
            $this->_profile->contact_data = $this->email;
            $this->_profile->save(false);

            $this->_profile->user_id = $this->_profile->contact_data = $this->getId();
            $this->_profile->nt_id = 2;
            $this->_profile->save(false);

        }
    }

    public static function listUsers( $defaultValue = null){

        $user = ArrayHelper::map( User::find()->select('id, username')->where('username!=:u', [':u'=>'admin'])->asArray()->all(), 'id', 'username');

        if ($defaultValue != null ){
            $user = [null => $defaultValue] + $user;
        }

        return $user;
    }
}

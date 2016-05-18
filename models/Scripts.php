<?php
/**
 * Created by PhpStorm.
 * User: aslan
 * Date: 11.05.2016
 * Time: 23:13
 */

namespace app\models;

//use yii\helpers\ArrayHelper;

class Scripts{

    protected $_notification;
    protected $_event;

    public function setNotification( $notification )
    {
        $this->_notification = $notification;
    }

    public function setEvent( $event )
    {
        $this->_event = $event;
    }

    public function sendMessage(){

        $notification = $this->_notification;
        $event = $this->_event;
        //$event_code = $event->data;
        $article = $event->sender;
       // new app\models\Articles();

        $insert_params = $article->toArray();
        $user_id = \Yii::$app->user->getId();

        $owners = Profile::find()->asArray()->select('user_id, nt_id, contact_data')->where('user_id!=:ui', [':ui' => $user_id])->all();
        $contact_data_list = $user_id_list = $inbox_container = array();

        if(!$owners){

            die("No profile found");
        }

        foreach( $owners as $value ){

            $nt_id = $value['nt_id'];
            $user_id = $value['user_id'];

            $contact_data_list[ $nt_id ][ $user_id ] = $value['contact_data'];

        }


        foreach( $notification as $key => $value){

            $profile = $value['userTo']['profile'];
            $subject = $value['title'];
            $article = \Yii::t('app', $value['article'], $insert_params);

            $content = [$subject, $article];
            $functionName = $value['nt']['nt_code'];                    //notification code or function name to be implemented


            if( $value['user_to'] != NULL ){


                if($value[ 'nt_id' ] == $profile['nt_id']){

                    $contact = $profile['contact_data'];

                    $inbox_container[] = [
                        'title'       => $subject,
                        'article'    => $article,
                        'user_from'  => $value["user_from"],
                        'user_to'    => $value["user_to"],
                        'nt_id'      => $value["nt_id"],
                        'created_at' => time()
                     ];

                    $this->$functionName($contact, $content);
                }

            }
            else{

                if(isset($contact_data_list[ $value[ 'nt_id' ] ])){

                    $contact_data = $contact_data_list[ $value[ 'nt_id' ] ] ;

                   /* var_dump( $contact_data);
                    die("Проверка контента");*/

                    foreach( $contact_data as $contact_index => $contact ){

                        $inbox_container[] = [
                            'title'       => $subject,
                            'article'    => $article,
                            'user_from'  => $value["user_from"],
                            'user_to'    => $contact_index,
                            'nt_id'      => $value["nt_id"],
                            'created_at' => time()
                        ];

                        $this->$functionName($contact, $content);
                    }
                }

            }

        }

        if( isset ($inbox_container) ){

            $attributes = array_keys($inbox_container[0]);

            \Yii::$app->db->createCommand()->batchInsert(Inbox::tableName(), $attributes, $inbox_container)->execute();
        }

    }

    protected function email($contact, $content){

       $mailer = \Yii::$app->mailer;

       $to = $contact;
       $subject = $content[0];
       $text = $content[1];

       $sender = isset(\Yii::$app->params['adminEmail']) ? \Yii::$app->params['adminEmail'] : 'no-reply@example.com';

       $mailer->compose()
           ->setFrom($sender)
           ->setTo($to)
           ->setSubject($subject)
           ->setTextBody($text)
           ->setHtmlBody('<b>' . $text . '</b>')
           ->send();
    }

    protected function browser( $contact, $details ){
        return true;
    }

    protected function telegram( $contact, $details ){
        //TODO complete
    }

    protected function sms( $contact, $details){
        //TODO complete
    }
} 
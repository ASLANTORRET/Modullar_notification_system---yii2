<?php
/**
 * Created by PhpStorm.
 * User: aslan
 * Date: 11.05.2016
 * Time: 13:17
 */

namespace app\models;
use dektrium\user\Mailer as BaseMailer;
use Yii;

class Mailer extends BaseMailer{

    public function getSubject()
    {
        if ($this->welcomeSubject == null) {
            $this->setWelcomeSubject('Заголовок');
        }

        return $this->welcomeSubject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->welcomeSubject = $subject;
    }

    public function sendNotificationMessage( $contact_data, $content)
    {

        if($contact_data[0] === TRUE){/*
            var_dump($contact_data);
            die('sds1');*/
            foreach($contact_data[1] as $value){

                $mailer = Yii::$app->mailer;

                $to = $value;
                $subject = $content[0];
                $text = $content[1];

                $sender = isset(Yii::$app->params['adminEmail']) ? Yii::$app->params['adminEmail'] : 'no-reply@example.com';

                $mailer->compose()
                    ->setFrom($sender)
                    ->setTo($to)
                    ->setSubject($subject)
                    ->setTextBody($text)
                    ->setHtmlBody('<b>{$text}</b>')
                    ->send();
            }
        }

        else{

            $mailer = Yii::$app->mailer;

            $to = $contact_data[0];
            $subject = $content[0];
            $text = $content[1];

            $sender = isset(Yii::$app->params['adminEmail']) ? Yii::$app->params['adminEmail'] : 'no-reply@example.com';

            $mailer->compose()
                ->setFrom($sender)
                ->setTo($to)
                ->setSubject($subject)
                ->setTextBody($text)
                ->setHtmlBody('<b>' . $text . '</b>')
                ->send();

        }


        /** @var \yii\mail\BaseMailer $mailer */

        return true;
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $view
     * @param array  $params
     *
     * @return bool
     */


} 
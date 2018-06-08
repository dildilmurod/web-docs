<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
            'name' => 'Name',
            'email' => 'e-mail',
            'subject' => 'Subject',
            'body' => 'Message',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */

    /* sending message to mail*/
    public function sendEmail($emailto)
    {
        Yii::$app->mailer->compose()
            ->setFrom([$this->email => $this->name])
            ->setTo($emailto)
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();

        return true;

    }
}

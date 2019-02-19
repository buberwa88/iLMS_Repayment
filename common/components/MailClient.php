<?php

namespace common\components;

/**
 * Description of MailClient
 * This mail client is used to send emails to any recipient using any SMT based server
 * We use the default Yii2 Swift Mailer class to send the mails to different recipients
 *
 * @author charles
 */
class MailClient {

    //put your code here
    public $from;
    public $to; ////for multile receipients use  comma separated list
    public $bcc;
    public $cc;
    public $subject;
    public $mail_body;

    public function __construct($config = []) {
        //   parent::__construct($config);
    }

    /*
     * sends email to the destination recipient
     * set $type='html' when you want to send an html based email
     */

    public function sendMail($type = NULL) {
        return \Yii::$app->mailer->compose($type)
                        ->setFrom($this->from)
                        ->setTo($this->to)
                        ->setSubject($this->subject)
                        ->setTextBody($this->mail_body)
                        ->setHtmlBody('<b>HTML content</b>')
                        ->send();
    }

}

<?php

namespace Core\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSender
{

    private $mail_host;
    private $mail_username;
    private $mail_password;
    private $mail_secure;
    private $mail_port;
    private $mail_from;
    private $mail_to;

    public function __construct($mail_host, $mail_username, $mail_password, $mail_secure, $mail_port, $mail_from, $mail_to)
    {
        $this->mail_host = $mail_host;
        $this->mail_username = $mail_username;
        $this->mail_password = $mail_password;
        $this->mail_secure = $mail_secure;
        $this->mail_port = $mail_port;
        $this->mail_from = $mail_from;
        $this->mail_to = $mail_to;
    }

    public function contact($firstname, $lastname, $email, $subject, $message){

        $mail = new PHPMailer(true);
        $mail->setLanguage('fr', '');

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->mail_host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->mail_username;                 // SMTP username
            $mail->Password = $this->mail_password;                           // SMTP password
            $mail->SMTPSecure = $this->mail_secure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->mail_port;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($this->mail_from['email'], $this->mail_from['name']);
            $mail->addAddress($this->mail_to['email'], $this->mail_to['name']);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = "Message de ". $firstname .' '. $lastname . " - Email : ". $email ."</br> Message :</br>".$message;

            $mail->send();

            return true;

        } catch (Exception $e) {

            $error = $mail->ErrorInfo;
            return $error;
        }

    }

}

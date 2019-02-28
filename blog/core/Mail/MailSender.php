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

    public function __construct($mail_host, $mail_username, $mail_password, $mail_secure, $mail_port)
    {
        $this->mail_host = $mail_host;
        $this->mail_username = $mail_username;
        $this->mail_password = $mail_password;
        $this->mail_secure = $mail_secure;
        $this->mail_port = $mail_port;
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
            $mail->setFrom('devcc@gmx.fr', 'Mailer');
            $mail->addAddress('mikael@mgmail.fr', 'Blog OCC');     // Add a recipient
            $mail->addReplyTo($email, $firstname . $lastname);

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();

            return true;

        } catch (Exception $e) {

            $error = $mail->ErrorInfo;
            return $error;
        }

    }

}

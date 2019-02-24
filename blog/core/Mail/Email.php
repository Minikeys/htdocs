<?php

namespace Core\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{

    public function contact($firstname, $lastname, $email, $subject, $message){

        $mail = new PHPMailer(true);
        $mail->setLanguage('fr', '');

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail.gmx.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'devcc@gmx.fr';                 // SMTP username
            $mail->Password = 'devcc1234';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

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

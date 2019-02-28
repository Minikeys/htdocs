<?php

namespace App\Controller;

use \App;

use Core\Mail\MailSender;

use Core\HTML\BootstrapForm;

class ContactController extends AppController
{

    public $page;

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $app = App::getInstance();
        $mail = $app->getMail();

        if(!empty($_POST)){

            $send = $mail->contact($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['subject'],$_POST['message']);

            if($send === true){

                $this->flashmessage->success('Votre message a été envoyé !');
                header('Location: index.php?p=contact');
                exit;


            } else {

                $this->flashmessage->error('Erreur : '. $send);
                header('Location: index.php?p=contact');
                exit;

            }

        }

        $form = new BootstrapForm($_POST);

        $this->render('Global.contact', compact('form', 'errors'));

    }

}

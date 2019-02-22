<?php

namespace App\Controller;

use \App;

use Core\Mail\Email;

use Core\HTML\BootstrapForm;

class ContactController extends AppController
{

    public $page;

    public function __construct()
    {
        parent::__construct();

        $this->mail = new Email();

    }

    public function index()
    {

        if(!empty($_POST)){

            $send = $this->mail->contact($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['subject'],$_POST['message']);

            if($send === true){

                $this->flashmessage->success('Votre message a été envoyé !');


            } else {

                $this->flashmessage->error('Erreur : '. $send);

            }

        }

        $form = new BootstrapForm($_POST);

        $this->render('global.contact', compact('form', 'errors'));

    }

}
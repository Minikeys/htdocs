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

    }

    public function index()
    {

        if(!empty($_POST)){

            $result = $this->User->create(
                ['name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'message' => $_POST['message']]);

            if ($result){

                $this->flashmessage->success('Votre message à bien été envoyé !');
                header('Location: index.php?p=contact');
                exit();

            }
        }

        $form = new BootstrapForm($_POST);

        $this->render('global.contact', compact('form', 'errors'));

    }

}
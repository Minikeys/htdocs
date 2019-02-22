<?php

namespace App\Controller;

use \App;

use Core\Auth\DBAuth;

use Core\HTML\BootstrapForm;


class UsersController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $this->loadModel('User');

    }

    public function login(){

        if(!empty($_POST)){

            $auth = new DBAuth(App::getInstance()->getDb());

            if($auth->login($_POST['username'], $_POST['password'])){

                header('Location: index.php?p=admin.posts.index');

            }else{

                $this->flashmessage->error('Identifiant ou mot de passe incorrect');

            }

        }

        $form = new BootstrapForm($_POST);

        $this->render('users.login', compact('form', 'errors'));
    }

    public function logout(){

        session_destroy();
        $this->flashmessage->success('Vous êtes déconnecté');
        header('Location: index.php?p=home');


    }

    public function register(){

        if(!empty($_POST)){

            $result = $this->User->create(
                ['username' => $_POST['username'],
                    'password' => sha1($_POST['password']),
                    'email' => $_POST['email']]);

            if ($result){

                $this->flashmessage->success('Compte créé avec succès !');
                header('Location: index.php?p=home');
                exit();

            }
        }

        $form = new BootstrapForm($_POST);

        $this->render('users.register', compact('form', 'errors'));

    }

}
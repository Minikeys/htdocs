<?php

namespace App\Controller;

use \App;

use Core\Auth\DBAuth;

use Core\HTML\BootstrapForm;


class UsersController extends AppController
{

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

}
<?php

namespace App\Controller;

use \App;

use Core\Auth\DBAuth;

use Core\HTML\BootstrapForm;

use Core\Session\FlashService;


class UsersController extends AppController
{

    public function login(){

        $this->flash = 'erreur';

        if(!empty($_POST)){

            $auth = new DBAuth(App::getInstance()->getDb());

            if($auth->login($_POST['username'], $_POST['password'])){

                header('Location: index.php?p=admin.posts.index');

            }else{

                FlashService::error($this->flash);

            }

        }

        $form = new BootstrapForm($_POST);

        $this->render('users.login', compact('form', 'errors'));
    }

}
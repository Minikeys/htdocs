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

                header('Location: index.php?p=home');

            }else{

                $this->flashmessage->error('Identifiant ou mot de passe incorrect');
                header('Location: index.php?p=users.login');
                exit;

            }

        }

        $form = new BootstrapForm($_POST);

        $this->render('Users.login', compact('form', 'errors'));
    }

    public function logout(){

        session_destroy();
        $this->flashmessage->success('Vous êtes déconnecté');
        header('Location: index.php?p=home');


    }

    public function register(){

        if(!empty($_POST)){

            $doublon = $this->User->checkUser($_POST['username'], $_POST['email']);

            if($doublon === null){

                $result = $this->User->create(
                    ['firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'password' => sha1($_POST['password']),
                        'email' => $_POST['email']]);

                if ($result){

                    $this->flashmessage->success('Compte créé avec succès !');
                    header('Location: index.php?p=users.register');
                    exit;

                }
            }else{

                $this->flashmessage->error('Username / Email déjà existant');
                header('Location: index.php?p=users.register');
                exit;

            }

        }

        $form = new BootstrapForm($_POST);

        $this->render('Users.register', compact('form', 'errors'));

    }

    public function account(){

        if(!empty($_POST)){

            $doublon = $this->User->checkUser($_POST['username'], $_POST['email'], $_SESSION['auth']);

            if(!empty($_POST['password']) && $doublon === null){

                $result = $this->User->update($_SESSION['auth'],
                    ['username' => $_POST['username'],
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'password' => sha1($_POST['password']),
                        'email' => $_POST['email']]);

                if ($result){

                    $this->flashmessage->success('Votre compte a été mis à jour !');
                    header('Location: index.php?p=users.account');
                    exit;

                }

            }elseif($doublon === null){

                $result = $this->User->update($_SESSION['auth'],
                    ['username' => $_POST['username'],
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'email' => $_POST['email']]);

                if ($result){

                    $this->flashmessage->success('Votre compte a été mis à jour !');
                    header('Location: index.php?p=users.account');
                    exit;

                }

            }else{

                $this->flashmessage->error('Adresse Email déjà utilisé sur un autre compte!');
                header('Location: index.php?p=users.account');
                exit;

            }

            }


        $data = $this->User->findUser($_SESSION['auth']);

        $form = new BootstrapForm($data);

        $this->render('Users.account', compact('form', 'errors'));

    }

}

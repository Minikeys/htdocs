<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;
use Core\Rooter\Rooter;
use \Core\Auth\DBAuth;

class UsersController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $app = App::getInstance();

        $auth = new DBAuth($app->getDb());

        if(is_null($auth->admin())){

            $this->forbidden();
        }

        $this->loadModel('User');

    }


    public function index(){

        $paginate = Rooter::get('d', 1);
        $users = $this->User->findPaginated(8, $paginate);
        $this->render('Admin.users.index', compact('users'));

    }

    public function upgrade(){

        if(!empty($_POST)){

            $result = $this->User->update($_POST['id'],
                ['grade' => '2']);

            if ($result){

                $this->flashmessage->success('Grade modifié');
                header('Location: index.php?p=admin.users.index');

            }
        }

    }

    public function downgrade(){

        if(!empty($_POST)){

            $result = $this->User->update($_POST['id'],
                ['grade' => '1']);

            if ($result){

                $this->flashmessage->success('Grade modifié');
                header('Location: index.php?p=admin.users.index');

            }
        }

    }

    public function desactived(){

        if(!empty($_POST)){

            $result = $this->User->update($_POST['id'],
                ['statut' => '1']);

            if ($result){

                $this->flashmessage->success('Utilisateur désactivé');
                header('Location: index.php?p=admin.users.index');

            }
        }

    }

    public function activate(){

        if(!empty($_POST)){

            $result = $this->User->update($_POST['id'],
                ['statut' => '0']);

            if ($result){

                $this->flashmessage->success('Utilisateur activé');
                header('Location: index.php?p=admin.users.index');

            }
        }

    }

}

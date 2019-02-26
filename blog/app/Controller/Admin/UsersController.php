<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;
use Core\Rooter\Rooter;

class UsersController extends AppController
{

    public function __construct()
    {

        parent::__construct();

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
                ['grade' => '1']);

            if ($result){

                $this->flashmessage->success('Grade modifié');
                header('Location: index.php?p=admin.users.index');

            }
        }

    }

    public function downgrade(){

        if(!empty($_POST)){

            $result = $this->User->update($_POST['id'],
                ['grade' => '0']);

            if ($result){

                $this->flashmessage->success('Grade modifié');
                header('Location: index.php?p=admin.users.index');

            }
        }

    }

    public function delete(){

        if(!empty($_POST)){

            $result = $this->User->delete($_POST['id']);

            if ($result){

                $this->flashmessage->success('Utilisateur supprimé');
                header('Location: index.php?p=admin.users.index');

            }
        }

    }

}

<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;
use Core\Rooter\Rooter;
use \Core\Auth\DBAuth;

class CommentsController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $app = App::getInstance();

        $auth = new DBAuth($app->getDb());

        if(is_null($auth->admin())){

            $this->forbidden();
        }

        $this->loadModel('Comment');

    }


    public function index(){

        $paginate = Rooter::get('d', 1);
        $comments = $this->Comment->findPaginated(8, $paginate);
        $this->render('Admin.comments.index', compact('comments'));

    }

    public function approve(){

        if(!empty($_POST)){

            $result = $this->Comment->update($_POST['id'],
                ['approved' => '1']);

            if ($result){

                $this->flashmessage->success('Commentaire approuvé');
                header('Location: index.php?p=admin.comments.index');

            }
        }

    }

    public function delete(){

        if(!empty($_POST)){

            $result = $this->Comment->delete($_POST['id']);

            if ($result){

                $this->flashmessage->success('Commentaire supprimé');
                header('Location: index.php?p=admin.comments.index');

            }
        }

    }

}

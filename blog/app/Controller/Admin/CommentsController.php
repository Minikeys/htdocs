<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;

class CommentsController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $this->loadModel('Comment');

    }


    public function index(){

        $comments = $this->Comment->all();
        $this->render('admin.comments.index', compact('comments'));

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
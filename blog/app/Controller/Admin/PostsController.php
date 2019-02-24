<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;

class PostsController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $this->loadModel('Post');

    }


    public function index(){

        $posts = $this->Post->last();
        $this->render('Admin.posts.index', compact('posts'));

    }

    public function add(){

        if(!empty($_POST)){

            $result = $this->Post->create(
                ['title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'category_id' => $_POST['category_id'],
                    'author'=> $_SESSION[auth],
                    'date_create'=> date('Y-m-d H:i:s')]);

            if ($result){

                $this->flashmessage->success('Article ajouté');
                header('Location: index.php?p=admin.posts.index');

            }
        }

        $this->loadModel('Category');

        $categories = $this->Category->extract('id', 'title');

        $form = new BootstrapForm($_POST);

        $this->render('Admin.posts.edit', compact('categories', 'form'));

    }

    public function edit(){

        if(!empty($_POST)){

            $result = $this->Post->update($_GET['id'],
                ['title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'category_id' => $_POST['category_id'],
                    'date_update'=> date('Y-m-d H:i:s')]);

            if ($result){

                $this->flashmessage->success('Article édité');
                header('Location: index.php?p=admin.posts.index');

            }
        }

        $post = $this->Post->find($_GET['id']);

        $this->loadModel('Category');

        $categories = $this->Category->extract('id', 'title');

        $form = new BootstrapForm($post);

        $this->render('Admin.posts.edit', compact('categories', 'form'));

    }

    public function delete(){

        if(!empty($_POST)){

            $result = $this->Post->delete($_POST['id']);

            if ($result){

                $this->flashmessage->success('Article supprimé');
                header('Location: index.php?p=admin.posts.index');

            }

        }

    }

}

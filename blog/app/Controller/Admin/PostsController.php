<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;
use Core\Rooter\Rooter;

class PostsController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $this->loadModel('Post');

    }


    public function index(){

        $paginate = Rooter::get('d', 1);

            if($_SESSION['grade'] == 2){

                $posts = $this->Post->findPaginated(8, $paginate);

            } else {

                $posts = $this->Post->findPaginatedByUser(8, $paginate, $_SESSION['auth']);

            }


        $this->render('Admin.posts.index', compact('posts'));

    }

    public function add(){

        if(!empty($_POST)){

            $result = $this->Post->create(
                ['title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'extract' => $_POST['extract'],
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

        if ($_SESSION['auth'] === $_POST['author']){
        if(!empty($_POST)){

            $result = $this->Post->update($_GET['id'],
                ['title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'extract' => $_POST['extract'],
                    'author'=> $_POST['author'],
                    'category_id' => $_POST['category_id'],
                    'date_update'=> date('Y-m-d H:i:s')]);

            if ($result){

                $this->flashmessage->success('Article édité');
                header('Location: index.php?p=admin.posts.index');

            }
        }
        }else{

            $this->flashmessage->error('Vous ne pouvez pas éditer l\'article d\'un autre utilisateur');
            header('Location: index.php?p=admin.posts.index');

        }

        $post = $this->Post->find($_GET['id']);

        $this->loadModel('Category');

        $this->loadModel('User');

        $categories = $this->Category->extract('id', 'title');

        $users = $this->User->extract('id', 'username');

        $form = new BootstrapForm($post);

        $this->render('Admin.posts.edit', compact('categories','users', 'form'));

    }

    public function delete(){

        if(empty($_POST)) {

            if ($_SESSION['grade'] == 2) {

                $result = $this->Post->deletepost($_POST['id']);

                if ($result) {

                    $this->flashmessage->success('Article supprimé');
                    header('Location: index.php?p=admin.posts.index');

                }

            }else{

                if ($_SESSION['auth'] === $_POST['author']){

                    $result = $this->Post->deletepost($_POST['id']);

                    if ($result) {

                        $this->flashmessage->success('Article supprimé');
                        header('Location: index.php?p=admin.posts.index');

                    }

                }

            }
        }
    }

}

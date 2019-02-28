<?php

namespace App\Controller;

use Core\HTML\BootstrapForm;
use Core\Rooter\Rooter;

class PostsController extends AppController
{

    public function __construct()
    {
        parent::__construct();

        $this->loadModel('Post');

        $this->loadModel('Category');

        $this->loadModel('Comment');

    }

    public function index(){

        $paginate = Rooter::get('d', 1);

        $posts = $this->Post->findPaginated(6, $paginate);
        $categories = $this->Category->allWithCount();

        $this->render('Posts.index', compact('posts', 'categories'));

    }

    public function category(){

        $categorie = $this->Category->find($_GET['id']);

        if($categorie === false){

            $this->notFound();

        }

        $paginate = Rooter::get('d', 1);

        $posts = $this->Post->lastByCategoryPaginated($_GET['id'], 6, $paginate);

        $categories = $this->Category->allWithCount();

        $this->render('Posts.category', compact('posts', 'categories', 'categorie'));

    }

    public function show(){

        $post = $this->Post->findWithCategory($_GET['id']);
        $comments = $this->Comment->show($_GET['id']);
        $categories = $this->Category->all();
        $user = $_SESSION['firstname'] . ' '. $_SESSION['lastname'];
        $form = new BootstrapForm($_POST);

        if(!empty($_POST)){

            $result = $this->Comment->create(
                ['id_article' => $_GET['id'],
                    'name' => $_POST['name'],
                    'content' => $_POST['content']]);

            if ($result){

                $this->flashmessage->success('Commentaire ajoutée');
                header('Location: index.php?p=posts.show&id='.$_GET['id']);
                exit;

            }
        }

        $this->render('Posts.show', compact('post', 'comments', 'categories','form', 'user'));

    }


}

<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;
use Core\Rooter\Rooter;
use \Core\Auth\DBAuth;

class CategoriesController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $this->loadModel('Category');

        $this->loadModel('Post');

        $app = App::getInstance();

        $auth = new DBAuth($app->getDb());

        if(is_null($auth->admin())){

            $this->forbidden();
        }

    }


    public function index(){

        $paginate = Rooter::get('d', 1);
        $categories = $this->Category->findPaginated(8, $paginate);

        $this->render('Admin.categories.index', compact('categories'));

    }

    public function add(){

        if(!empty($_POST)){

            $result = $this->Category->create(
                ['title' => $_POST['title']]);
            if ($result){
                $this->flashmessage->success('Catégorie ajoutée');
                header('Location: index.php?p=admin.categories.index');
            }

        }

        $form = new BootstrapForm($category);

        $this->render('Admin.categories.edit', compact('form'));

    }

    public function edit(){

        if(!empty($_POST)){

            $result = $this->Category->update($_GET['id'],
                ['title' => $_POST['title']]);
            if ($result){
                $this->flashmessage->success('Catégorie éditée');
                header('Location: index.php?p=admin.categories.index');
            }

        }

        $category = $this->Category->find($_GET['id']);

        $form = new BootstrapForm($category);

        $this->render('Admin.categories.edit', compact('form'));

    }

    public function delete(){

        if(!empty($_POST)){

            if($_POST['id'] > 1){

                $result = $this->Category->deletecategory($_POST['id']);

                if ($result){

                    $this->flashmessage->success('Catégorie supprimée');
                    header('Location: index.php?p=admin.categories.index');

                }
            }else{
                $this->flashmessage->error('La catégorie ne peut être supprimé');
                header('Location: index.php?p=admin.categories.index');
            }



        }

    }

}

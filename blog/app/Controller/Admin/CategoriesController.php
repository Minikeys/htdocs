<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;

class CategoriesController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $this->loadModel('Category');

    }


    public function index(){

        $items = $this->Category->all();

        $this->render('admin.categories.index', compact('items'));

    }

    public function add(){

        if(!empty($_POST)){

            $result = $this->Category->create(
                ['title' => $_POST['title']]);

            $this->flashmessage->success('Catégorie ajoutée');
            header('Location: index.php?p=admin.categories.index');


        }

        $form = new BootstrapForm($category);

        $this->render('admin.categories.edit', compact('form'));

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

        $this->render('admin.categories.edit', compact('form'));

    }

    public function delete(){

        if(!empty($_POST)){

            $result = $this->Category->delete($_POST['id']);

            if ($result){

                $this->flashmessage->success('Catégorie supprimée');
                header('Location: index.php?p=admin.categories.index');

            }
        }

    }

}

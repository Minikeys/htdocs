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

            return $this->index();


        }

        $form = new BootstrapForm($category);

        $this->render('admin.categories.edit', compact('form'));

    }

    public function edit(){

        if(!empty($_POST)){

            $result = $this->Category->update($_GET['id'],
                ['title' => $_POST['title']]);

            return $this->index();

        }

        $category = $this->Category->find($_GET['id']);

        $form = new BootstrapForm($category);

        $this->render('admin.categories.edit', compact('form'));

    }

    public function delete(){

        if(!empty($_POST)){

            $result = $this->Category->delete($_POST['id']);

            if ($result){

                return $this->index();
            }
        }

    }

}
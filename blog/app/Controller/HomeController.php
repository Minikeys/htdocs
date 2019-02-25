<?php

namespace App\Controller;

class HomeController extends AppController
{

    public function __construct()
    {
        parent::__construct();

        $this->loadModel('Post');

        $this->loadModel('Category');

    }

    public function index()
    {

        if(isset($_GET['d'])){

            $paginpage = $_GET['d'];

        }else{

            $paginpage = '1';

        }

        $posts = $this->Post->findPaginated(4, $paginpage);

        $categories = $this->Category->all();

        $this->render('Global.home', compact('posts', 'categories'));

    }

}

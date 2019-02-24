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

        $posts = $this->Post->home();
        $categories = $this->Category->all();

        $this->render('global.home', compact('posts', 'categories'));

    }

}

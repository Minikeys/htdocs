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

        $posts = $this->Post->last();
        $categories = $this->Category->all();

        $this->render('posts.index', compact('posts', 'categories'));

    }

}
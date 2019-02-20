<?php

namespace App\Controller;

use \App;

use Core\Auth\DBAuth;

use Core\HTML\BootstrapForm;

class ContactController extends AppController
{

    public $page;

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
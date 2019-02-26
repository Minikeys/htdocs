<?php

namespace App\Controller;
use Core\Rooter\Rooter;

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

        $paginate = Rooter::get('d', 1);

        $posts = $this->Post->findPaginated(4, $paginate);

        $categories = $this->Category->all();

        $this->render('Global.home', compact('posts', 'categories'));

    }

}

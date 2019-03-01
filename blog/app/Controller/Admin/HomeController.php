<?php

namespace App\Controller\Admin;

use App;

class HomeController extends AppController
{

    public function __construct()
    {

        parent::__construct();

        $this->loadModel('Post');
        $this->loadModel('Category');
        $this->loadModel('Comment');
        $this->loadModel('User');

    }


    public function index(){

        $countposts = $this->Post->countposts();
        $countcategories = $this->Category->countcategories();
        $countcomments = $this->Comment->countcomments();
        $countusers = $this->User->countusers();
        $counts = ['posts'=>['value' => $countposts[0]->total, 'name' => 'articles', 'id' => 'posts'], 'categories'=>['value' => $countcategories[0]->total, 'name' => 'catégories', 'id' => 'categories'], 'comments'=>['value' => $countcomments[0]->total, 'name' => 'commentaires', 'id' => 'comments'], 'users'=>['value' => $countusers[0]->total, 'name' => 'utilisateurs', 'id' => 'users']];
        $this->render('Admin.home', compact('counts'));

    }

}

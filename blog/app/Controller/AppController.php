<?php

namespace App\Controller;

use Core\Controller\Controller;

use Core\Twig\FlashExtensions;
use Core\Twig\TemplateExtensions;

use \App;

class AppController extends Controller
{

    protected $twig;

    protected $loader;

    public function __construct()
    {

        $this->viewPath = ROOT . '/app/Views/';

        $this->loader = new \Twig_Loader_Filesystem($this->viewPath);

        $this->twig = new \Twig_Environment($this->loader, ['debug' => true]);

        $this->twig->addExtension(new TemplateExtensions());

        $this->twig->addExtension(new FlashExtensions());

        $this->twig->addExtension(new \Twig_Extension_Debug());

    }

    protected function loadModel($model_name){

        $this->$model_name = \App::getInstance()->getTable($model_name);

    }


}
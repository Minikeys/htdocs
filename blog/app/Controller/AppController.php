<?php

namespace App\Controller;

use Core\Controller\Controller;

use Core\Rooter\Rooter;
use Core\Twig\FlashExtensions;
use Core\Twig\TemplateExtensions;
use Core\Twig\PagerFantaExtension;

use Core\Session\FlashService;

use \App;

class AppController extends Controller
{

    protected $twig;

    protected $loader;

    public $flashmessage;

    public $page;

    public function __construct()
    {

        $this->viewPath = ROOT . '/app/Views/';

        $this->loader = new \Twig_Loader_Filesystem($this->viewPath);

        $this->twig = new \Twig_Environment($this->loader, ['debug' => true]);

        $this->twig->addExtension(new TemplateExtensions());

        $this->twig->addExtension(new FlashExtensions());

        $this->twig->addExtension(new PagerFantaExtension());

        $this->twig->addExtension(new \Twig_Extension_Debug());

        $this->twig->addExtension(new \Twig_Extensions_Extension_Text());

        $page = Rooter::get('p', 'home.index');

        $logo = \App::getInstance()->getParam('logo_app');

        $name = \App::getInstance()->getParam('name_app');

        $pagewithid = $page.'&id='.Rooter::get('id', null);

        $this->twig->addGlobal('current_page', $page);

        $this->twig->addGlobal('current_page_id', $pagewithid);

        $this->twig->addGlobal('nameapp', $name);

        $this->twig->addGlobal('logo', $logo);

        $this->twig->addGlobal('session', $_SESSION);

        $this->flashmessage = new FlashService();

    }

    protected function loadModel($model_name){

        $this->$model_name = \App::getInstance()->getTable($model_name);

    }


}

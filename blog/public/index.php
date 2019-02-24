<?php

define('ROOT', dirname(__DIR__));

require ROOT . '/app/App.php';

require ROOT . '/vendor/autoload.php';

require ROOT . '/core/Twig/TemplateExtensions.php';

require ROOT . '/core/Twig/FlashExtensions.php';

require ROOT . '/core/Session/SessionInterface.php';

App::load();

if(isset($_GET['p'])){

    $page = $_GET['p'];

}else{

    $page = 'home.index';

}

$page = explode('.', $page);

if($page[0] == 'admin'){

    $controller = '\App\Controller\Admin\\' . ucfirst($page[1]) . 'Controller';

    $action = $page[2];

} else {

    $controller = '\App\Controller\\' . ucfirst($page[0]) . 'Controller';

    $action = isset($page[1])? $page[1] : 'index';

}

$controller = new $controller();

$controller->$action();



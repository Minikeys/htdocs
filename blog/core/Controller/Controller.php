<?php

namespace Core\Controller;

class Controller
{

    protected $viewPath = ROOT . '/app/Views/';

    protected $template;

    protected function render(string $view, array $variables = []){

        ob_start();

        extract($variables);

        $template = $this->twig->load(str_replace('.', '/', $view) .'.twig');

        ob_get_clean();

        //var_dump($variables);

        echo $template->render(['variable' => $variables]);

    }

    protected function forbidden(){

        header("HTTP/1.1 403 Forbidden");

        die('Acces interdit');

    }

    protected function notFound(){

        header("HTTP/1.1 404 Not Found");

        die('Page introuvable');
    }

}
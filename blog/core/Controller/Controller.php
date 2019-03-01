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

        echo $template->render(['variable' => $variables]);

    }

    protected function forbidden(){

        $this->flashmessage->error('Vous devez être connecté !');
        header('Location: index.php?p=users.login');
        exit;

    }

    protected function notFound(){
        $this->flashmessage->error('La page n\'existe pas ou plus :( ');
        header('Location: index.php?p=home');
        exit;
    }

}

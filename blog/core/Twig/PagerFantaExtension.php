<?php

namespace Core\Twig;


use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;

class PagerFantaExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('paginate', [$this, 'paginate'], ['is_safe' => ['html']])
        ];
    }

    public function paginate(Pagerfanta $paginatedResults, string $route): string
    {
        $view = new TwitterBootstrap4View();
        $options = array('css_container_class' => 'pagination justify-content-center');
        $routeGenerator = function($page) use ($route) {
        return 'index.php?p='.$route.'&d='.$page;};
        return $view->render($paginatedResults, $routeGenerator, $options);
    }
}

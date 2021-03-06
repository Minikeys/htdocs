<?php

namespace Core\Twig;


use Core\Session\FlashService;

class FlashExtensions extends \Twig_Extension
{

    /**
     * @var FlashService
     */
    private $flashService;

    public function __construct()
    {
        $this->flashService = new FlashService();
    }

    public function getFunctions(): array
    {
        return [

            new \Twig_SimpleFunction('flash', [$this, 'getFlash'])

        ];
    }

    public function getFlash($type): ?string
    {

        return $this->flashService->get($type);

    }

}

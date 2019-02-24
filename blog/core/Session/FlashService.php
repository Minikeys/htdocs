<?php

namespace Core\Session;


class FlashService
{

    /**
     * @var SessionInterface
     */
    private $session;

    private $session_key = 'flash';

    private $messages;

    public function __construct()
    {

        $this->session = new PHPSession();
    }

    public function success(string $message){

        $flash = $this->session->get($this->session_key, []);
        $flash['success'] = $message;
        $this->session->set($this->session_key, $flash);

    }

    public function error(string $message){

        $flash = $this->session->get($this->session_key, []);
        $flash['error'] = $message;
        $this->session->set($this->session_key, $flash);

    }

    public function get(string $type): ?string
    {
        if(is_null($this->messages)) {

            $this->messages = $this->session->get($this->session_key, []);
            $this->session->delete($this->session_key);
            unset($_SESSION[$this->session_key]);


        }

        if(array_key_exists($type, $this->messages)){

            return $this->messages[$type];

        }

        return null;

    }

}

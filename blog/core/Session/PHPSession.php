<?php

namespace Core\Session;


class PHPSession implements SessionInterface
{
    /**
     * Check if Session are started
     */
    private function ensureStarted(){

        if(session_status() == PHP_SESSION_NONE){

            session_start();

        }

    }

    /**
     * Get information in Session
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();

        if(array_key_exists($key, $_SESSION)){

            return $_SESSION[$key];

        }

        return $default;
    }

    /**
     * Add information in Session
     *
     * @param string $key
     * @param $value
     *
     */
    public function set(string $key, $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Delete key in Session
     *
     * @param $key
     *
     */
    public function delete($key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }
}
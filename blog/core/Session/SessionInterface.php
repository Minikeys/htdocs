<?php

namespace Core\Session;

interface SessionInterface
{
    /**
     * Get information in Session
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key,  $default = null);

    /**
     * Add information in Session
     *
     * @param string $key
     * @param $value
     *
     */
    public function set(string $key, $value): void;


    /**
     * Delete key in Session
     *
     * @param $key
     *
     */
    public function delet($key): void;

}
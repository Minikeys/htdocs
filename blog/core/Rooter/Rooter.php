<?php

namespace Core\Rooter;

class Rooter
{

    public static function get($id, $default){

        if(isset($_GET[$id])){

            return $_GET[$id];

        }else{

            return $default;

        }

    }

}
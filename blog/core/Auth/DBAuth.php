<?php

namespace Core\Auth;

use Core\Database\Database;

class DBAuth
{

    private $db;

    public function __construct(Database $db)
    {

        $this->db = $db;

    }

    /**
     * @param $username
     * @param $password
     * @return boolean
     */

    public function login($username, $password){

        $user = $this->db->prepare('SELECT * FROM users WHERE username =?', [$username], null, true);

        if($user){

            if($user->password === sha1($password)){

                if($user->statut == 0){

                $_SESSION['auth'] = $user->id;
                $_SESSION['grade'] = $user->grade;
                $_SESSION['firstname'] = $user->firstname;
                $_SESSION['lastname'] = $user->lastname;
                $_SESSION['email'] = $user->email;

                return true;
                }

            }

        }

        return false;


    }

    public function logged(){

        return $_SESSION['grade'];

    }

    public function getUserId(){

        if($this->logged()){

            return $_SESSION['auth'];

        }

        return false;

    }

    public function admin(){

        if($_SESSION['grade'] == 1){

            return $_SESSION['grade'];

        }else{

            return null;
        }


    }

}

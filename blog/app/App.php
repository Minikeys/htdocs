<?php

use Core\Config;
use Core\Database\MysqlDatabase;
use Core\Mail\MailSender;

class App{

    private $db_instance;

    private $mail_instance;

    private static $_instance;

    public static function getInstance(){

        if(is_null(self::$_instance)){

            self::$_instance = new App();

        }

        return self::$_instance;

    }

    public static function load(){

        session_start();

        require ROOT . '/app/Autoloader.php';

        App\Autoloader::register();

        require ROOT . '/core/Autoloader.php';

        Core\Autoloader::register();

    }

    public function getTable($name){

        $class_name = '\\App\\Table\\' . ucfirst($name) . 'Table';

        return new $class_name($this->getDb());

    }

    public function getDb(){

        $config = Config::getInstance(ROOT . '/config/config.php');

        if(is_null($this->db_instance)){

            $this->db_instance = new MysqlDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));

        }

        return $this->db_instance;

    }

    public function getMail(){

        $config = Config::getInstance(ROOT . '/config/config.php');

        if(is_null($this->mail_instance)){

            $this->mail_instance = new MailSender($config->get('mail_host'), $config->get('mail_username'), $config->get('mail_password'), $config->get('mail_secure'), $config->get('mail_port'), $config->get('mail_from'), $config->get('mail_to'));

        }

        return $this->mail_instance;

    }

}

<?php

namespace App\Entity;

use Core\Entity\Entity;

class PostEntity extends Entity{

    public function getURL(){

        return 'index.php?p=posts.show&id=' . $this->id;

    }

    public function getExtrait()
    {

        $html = substr($this->content, 0, 100) ;


        return $html;
    }


}
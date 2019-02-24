<?php

namespace App\Entity;

use Core\Entity\Entity;

class CategoryEntity extends Entity{

    public function getURL(){

        return 'index.php?p=posts.category&id=' . $this->id;

    }


}

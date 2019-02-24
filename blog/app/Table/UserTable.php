<?php

namespace App\Table;

use Core\Table\Table;

class UserTable extends Table
{

    public function findUser($username){

        $finduser = $this->query("
                  SELECT id
                  
                  FROM users
                  
                  WHERE username = ?", [$username], true);

        if (!empty($finduser)){

            return $finduser;

        }


    }

}

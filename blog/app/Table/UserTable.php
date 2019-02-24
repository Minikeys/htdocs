<?php

namespace App\Table;

use Core\Table\Table;

class UserTable extends Table
{

    public function findUser($username, $email){

        $finduser = $this->query("
                  SELECT id
                  
                  FROM users
                  
                  WHERE username = ?", [$username], true);

        if (!empty($finduser)){

            return $finduser;

        } else {

            $findemail = $this->query("
                  SELECT id
                  
                  FROM users
                  
                  WHERE email = ?", [$email], true);

            if (!empty($findemail)){

                return $findemail;

        }
        }

    }

}

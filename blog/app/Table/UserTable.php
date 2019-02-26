<?php

namespace App\Table;

use \App;
use Core\Table\PaginatedQuery;
use Core\Table\Table;
use Pagerfanta\Pagerfanta;

class UserTable extends Table
{

    protected $table = 'users';

    public function findUser($username, $email){

        $finduser = $this->query("
                  SELECT id
                  
                  FROM {$this->table}
                  
                  WHERE username = ?", [$username], true);

        if (!empty($finduser)){

            return $finduser;

        } else {

            $findemail = $this->query("
                  SELECT id
                  
                  FROM {$this->table}
                  
                  WHERE email = ?", [$email], true);

            if (!empty($findemail)){

                return $findemail;

        }
        }

    }

    public function findPaginated(int $perPage, int $paginPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->db,
            'SELECT users.id, users.username, users.firstname, users.lastname, users.email, users.grade
            FROM users',
            'ORDER BY users.id ASC',
            'SELECT COUNT(id) AS total FROM users',
            null
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($paginPage);

    }

    public function all(){

        return $this->query("
                  SELECT users.id, users.username, users.firstname, users.lastname, users.email, users.grade
                  
                  FROM {$this->table}");

    }

}

<?php

namespace App\Table;

use \App;
use Core\Table\PaginatedQuery;
use Core\Table\Table;
use Pagerfanta\Pagerfanta;

class UserTable extends Table
{

    protected $table = 'users';

    public function findUser($id)
    {

        $finduser = $this->query("
                  SELECT username, firstname, lastname, email
                  
                  FROM {$this->table}
                  
                  WHERE id = ?", [$id], true);

        if (!empty($finduser)) {

            return $finduser;

        }
    }

    public function checkUser($username, $email, $id = null){

        if(is_null($id)) {

            $checkUser = $this->query("
                  SELECT id
                  
                  FROM {$this->table}
                  
                  WHERE username = ? OR email = ?", [$username, $email], false);

            if (!empty($checkUser)) {

                return $checkUser;

            }
        }else{

            $checkUser = $this->query("
                  SELECT id
                  
                  FROM {$this->table}
                  
                  WHERE id != ? AND (username = ? OR email = ?)", [$id, $username, $email], false);

            if (!empty($checkUser)) {

                return $checkUser;

            }

        }

    }

    public function findPaginated(int $perPage, int $paginPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->db,
            'SELECT users.id, users.username, users.firstname, users.lastname, users.email, users.grade, users.statut
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
                  SELECT users.id, users.username, users.firstname, users.lastname, users.email, users.grade, users.statut
                  
                  FROM {$this->table}");

    }

    public function countusers(){

        return $this->query("SELECT COUNT(id) as total FROM {$this->table}");


    }

}

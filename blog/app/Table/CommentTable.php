<?php

namespace App\Table;

use \App;
use Core\Database\Database;
use Core\Table\PaginatedQuery;
use Core\Table\Table;
use Pagerfanta\Pagerfanta;

class CommentTable extends Table
{

    protected $table = 'comments';

    /**
     * Récupère un article en liant la catégorie associée
     * @param $id int
     * @return \App\Entity\PostEntity
     */

    public function show($id){

        return $this->query("
                  
                  SELECT comments.id, comments.content, comments.name, comments.approved
                  
                  FROM {$this->table}
                  
                  WHERE comments.id_article = ? AND comments.approved = 1", [$id], false);


    }

    public function all(){

        return $this->query("
                  
                  SELECT comments.id, comments.content, comments.name, comments.approved
                  
                  FROM {$this->table}");


    }

    public function findPaginated(int $perPage, int $paginPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->db,
            'SELECT comments.id, comments.content, comments.name, comments.approved
            FROM comments',
            'ORDER BY comments.date_create DESC',
            'SELECT COUNT(id) AS total FROM comments',
            null
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($paginPage);

    }

    public function countcomments(){

        return $this->query("SELECT COUNT(id) as total FROM {$this->table}");


    }

}

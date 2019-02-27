<?php

namespace App\Table;

use \App;
use Core\Table\PaginatedQuery;
use Core\Table\Table;
use Pagerfanta\Pagerfanta;

class CategoryTable extends Table
{

    protected $table = "categories";

    public function findPaginated(int $perPage, int $paginPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->db,
            'SELECT *
            FROM categories',
            'ORDER BY categories.id ASC',
            'SELECT COUNT(id) AS total FROM categories',
            null
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($paginPage);

    }

    public function deletecategory($id){

        return $this->query("UPDATE posts SET category_id = 1; DELETE FROM {$this->table} WHERE id = ?", [$id], false);


    }

    public function countcategories(){

        return $this->query("SELECT COUNT(id) as total FROM {$this->table}");


    }


}

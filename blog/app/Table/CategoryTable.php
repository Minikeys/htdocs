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

}

<?php

namespace App\Table;

use \App;
use Core\Table\PaginatedQuery;
use Core\Table\Table;
use Pagerfanta\Pagerfanta;

class PostTable extends Table
{

    protected $table = 'posts';
    public $category_id;
    protected $iduser;
    public $num_posts_home;

    /**
     * Récupère les derniers articles
     * @return array
     */

    public function last(){

        return $this->query("
                  SELECT posts.id, posts.title, posts.content, posts.extract, posts.date_update, categories.title as category, users.firstname as firstname
                  
                  FROM {$this->table} LEFT JOIN categories ON category_id = categories.id LEFT JOIN users ON author = users.id
                  
                  ORDER BY posts.date_update DESC");


    }

    /**
     * Récupère les 5 derniers articles
     * @return array
     */

    public function home(){

        $this->num_posts_home = \App::getInstance()->getParam('num_posts_home');

        return $this->query("
                  SELECT posts.id, posts.title, posts.content, posts.extract, posts.date_update, categories.title as category, users.firstname as firstname
                  
                  FROM {$this->table} LEFT JOIN categories ON category_id = categories.id LEFT JOIN users ON author = users.id
                  
                  ORDER BY posts.date_update DESC LIMIT 0, {$this->num_posts_home}");


    }

    /**
     * Récupère un article en liant la catégorie associée
     * @param $id int
     * @return \App\Entity\PostEntity
     */

    public function findWithCategory($id){

        return $this->query("
                  SELECT posts.id, posts.title, posts.content, posts.extract, categories.title as category
                  
                  FROM {$this->table} LEFT JOIN categories ON category_id = categories.id
                  
                  WHERE posts.id = ?", [$id], true);


    }

    /**
     * Récupère les derniers articles de la catégorie
     * @param $category_id int
     * @return array
     */

    public function lastByCategory($category_id){

        return $this->query("
                  SELECT posts.id, posts.title, posts.content, posts.extract, categories.title as category
                  
                  FROM {$this->table} LEFT JOIN categories ON category_id = categories.id
                  
                  WHERE posts.category_id = ?
                  
                  ORDER BY posts.date_update DESC", [$category_id]);


    }

    public function count($id){

        $count = $this->query("SELECT * FROM {$this->table} WHERE category_id = ? ", [$id], true);

        if (!empty($count)){

            return $count;

        }

    }

    public function findPaginated(int $perPage, int $paginPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->db,
            'SELECT posts.id, posts.title, posts.content, posts.extract, posts.date_update, categories.title as category, users.firstname as firstname
            FROM posts LEFT JOIN categories ON category_id = categories.id LEFT JOIN users ON author = users.id',
            'ORDER BY posts.date_update DESC',
            'SELECT COUNT(id) AS total FROM posts',
            null
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($paginPage);

    }

    public function findPaginatedByUser(int $perPage, int $paginPage, int $id): Pagerfanta
    {

        $this->iduser = $id;
        $query = new PaginatedQuery(
            $this->db,
            'SELECT posts.id, posts.title, posts.content, posts.extract, posts.date_update, posts.author, categories.title as category, users.firstname as firstname
            FROM posts LEFT JOIN categories ON category_id = categories.id LEFT JOIN users ON author = users.id',
            'ORDER BY posts.date_update DESC',
            'SELECT COUNT(id) AS total FROM posts',
            true,
            ['value' => 'author', 'id' => $this->iduser]
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($paginPage);

    }

    public function lastByCategoryPaginated(int $category_id, int $perPage, int $paginPage): Pagerfanta
    {

        $this->category_id = $category_id;

        $query = new PaginatedQuery(
            $this->db,
            'SELECT posts.id, posts.title, posts.content, posts.extract, categories.title as category 
            FROM posts LEFT JOIN categories ON category_id = categories.id',
            'ORDER BY posts.date_update DESC',
            'SELECT COUNT(id) AS total FROM posts',
            true,
            ['value' => 'category_id', 'id' => $this->category_id]
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($paginPage);


    }

    public function deletepost($id){

            return $this->query("DELETE FROM comments WHERE id_article = ?; DELETE FROM {$this->table} WHERE id = ?", [$id, $id], false);


    }

    public function countposts(){

        return $this->query("SELECT COUNT(id) as total FROM {$this->table}");


    }

}

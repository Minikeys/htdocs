<?php

namespace App\Table;

use Core\Table\Table;

class PostTable extends Table
{

    protected $table = 'articles';

    /**
     * Récupère les derniers articles
     * @return array
     */

    public function last(){

        return $this->query("
                  SELECT articles.id, articles.title, articles.content, articles.date_update, categories.title as category, users.firstname as firstname
                  
                  FROM articles LEFT JOIN categories ON category_id = categories.id LEFT JOIN users ON author = users.id
                  
                  ORDER BY articles.date_update DESC");


    }

    /**
     * Récupère les 5 derniers articles
     * @return array
     */

    public function home(){

        return $this->query("
                  SELECT articles.id, articles.title, articles.content, articles.date_update, categories.title as category, users.firstname as firstname
                  
                  FROM articles LEFT JOIN categories ON category_id = categories.id LEFT JOIN users ON author = users.id
                  
                  ORDER BY articles.date_update DESC LIMIT 4");


    }

    /**
     * Récupère un article en liant la catégorie associée
     * @param $id int
     * @return \App\Entity\PostEntity
     */

    public function findWithCategory($id){

        return $this->query("
                  SELECT articles.id, articles.title, articles.content, categories.title as category
                  
                  FROM articles LEFT JOIN categories ON category_id = categories.id
                  
                  WHERE articles.id = ?", [$id], true);


    }

    /**
     * Récupère les derniers articles de la catégorie
     * @param $category_id int
     * @return array
     */

    public function lastByCategory($category_id){

        return $this->query("
                  SELECT articles.id, articles.title, articles.content, categories.title as category
                  
                  FROM articles LEFT JOIN categories ON category_id = categories.id
                  
                  WHERE articles.category_id = ?
                  
                  ORDER BY articles.date_update DESC", [$category_id]);


    }

}

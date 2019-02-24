<?php

namespace App\Table;

use Core\Table\Table;

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
                  
                  SELECT comments.id, comments.content, users.firstname as firstname, comments.approved
                  
                  FROM comments LEFT JOIN users ON id_user = users.id
                  
                  WHERE comments.id_article = ? AND comments.approved = 1", [$id], false);


    }

    public function all(){

        return $this->query("
                  
                  SELECT comments.id, comments.content, users.username as username, comments.approved
                  
                  FROM comments LEFT JOIN users ON id_user = users.id");


    }

}

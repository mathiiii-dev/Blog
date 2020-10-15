<?php

namespace App\Model\Repository;

use App\Model\DbManager;
use App\Model\Post;

class PostRepository extends DbManager
{
    public function __construct()
    {
        $this->dbConnect();
    }

    public function getPostById($id)
    {
        $post = $this->dbConnect()->prepare("SELECT * FROM Post WHERE id = :id");
        $post->bindValue(':id', $id);
        $post->execute();
        $post->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');
        return $post->fetch();
    }

}

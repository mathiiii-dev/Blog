<?php

namespace App\Model\Repository;

use App\Model\DbManager;
use App\Model\Post;
use App\Model\PostsManager;

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

    public function addPost(Post $post)
    {
        $addPost = $this->dbConnect()->prepare(
            'INSERT INTO Post (idUser, title, lead, content, createdAt, isValid) 
            VALUES (:idUser, :title, :lead, :content, :createdAt, :isValid)'
        );

        $addPost->bindValue(':idUser', $post->getIdUser(), \PDO::PARAM_INT);
        $addPost->bindValue(':title', $post->getTitle(), \PDO::PARAM_STR);
        $addPost->bindValue(':lead', $post->getLead(), \PDO::PARAM_STR);
        $addPost->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
        $addPost->bindValue(':createdAt', $post->getCreatedAt(), \PDO::PARAM_STR);
        $addPost->bindValue(':isValid', $post->getIsValid(), \PDO::PARAM_INT);
        $addPost->execute();
    }

    public function getUserForAPost($idPost)
    {
        $post = $this->dbConnect()->prepare("SELECT firstname FROM User u, Post p WHERE p.idUser = u.id AND p.id = :idPost");
        $post->bindValue(':idPost', $idPost);
        $post->execute();
        $post->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');
        return $post->fetch();
    }

    public function modifyPost($idPost, Post $post)
    {
        $modifyPost = $this->dbConnect()->prepare(
            'UPDATE Post SET title = :title, lead = :lead, content = :content, updatedAt = :updatedAt WHERE id = :idPost'
        );

        $modifyPost->bindValue(':title', $post->getTitle(), \PDO::PARAM_STR);
        $modifyPost->bindValue(':lead', $post->getLead(), \PDO::PARAM_STR);
        $modifyPost->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
        $modifyPost->bindValue(':updatedAt', $post->getUpdateAt(), \PDO::PARAM_STR);
        $modifyPost->bindValue(':idPost', $idPost, \PDO::PARAM_INT);
        $modifyPost->execute();
    }

    public function deletePost($idPost)
    {
        $deletePost = $this->dbConnect()->prepare(
            'DELETE FROM Post WHERE id = :idPost'
        );

        $deletePost->bindValue(':idPost', $idPost, \PDO::PARAM_INT);

        $deletePost->execute();

    }

}

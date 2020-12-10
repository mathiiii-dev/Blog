<?php

namespace App\Repository;

use App\Services\DbManager;
use App\Model\Post;

class PostRepository extends DbManager
{
    public function __construct()
    {
        $this->dbConnect();
    }

    public function getPostById(int $id)
    {
        $post = $this->dbConnect()->prepare("SELECT * FROM Post WHERE id = :id AND isValid = 1");
        $post->bindValue(':id', $id);
        $post->execute();
        $post->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, MODEL_POST);
        return $post->fetch();
    }

    public function addPost(Post $post): void
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

    public function getUserForAPost(int $idPost)
    {
        $post = $this->dbConnect()->prepare("SELECT pseudo FROM User u, Post p WHERE p.idUser = u.id AND p.id = :idPost");
        $post->bindValue(ID_POST, $idPost);
        $post->execute();
        $post->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, MODEL_POST);
        return $post->fetch();
    }

    public function modifyPost(int $idPost, Post $post): void
    {
        $modifyPost = $this->dbConnect()->prepare(
            'UPDATE Post SET idUser = :idUser, title = :title, lead = :lead, content = :content, updatedAt = :updatedAt WHERE id = :idPost'
        );

        $modifyPost->bindValue(':title', $post->getTitle(), \PDO::PARAM_STR);
        $modifyPost->bindValue(':lead', $post->getLead(), \PDO::PARAM_STR);
        $modifyPost->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
        $modifyPost->bindValue(':updatedAt', $post->getUpdateAt(), \PDO::PARAM_STR);
        $modifyPost->bindValue(ID_POST, $idPost, \PDO::PARAM_INT);
        $modifyPost->bindValue(':idUser', $post->getIdUser(), \PDO::PARAM_INT);
        $modifyPost->execute();
    }

    public function deletePost(int $idPost): void
    {
        $deletePost = $this->dbConnect()->prepare(
            'DELETE FROM Post WHERE id = :idPost'
        );

        $deletePost->bindValue(ID_POST, $idPost, \PDO::PARAM_INT);

        $deletePost->execute();
    }

    public function getAllPost($perPage, $offset)
    {
        $post = $this->dbConnect()->prepare("SELECT post.id, user.pseudo, post.title, post.lead, post.createdAt, post.updatedAt FROM 
                                            post, user WHERE post.idUser = user.id AND isValid = 1 ORDER BY post.id DESC LIMIT :perPage OFFSET :offset ");
        $post->bindValue(':perPage', $perPage, \PDO::PARAM_INT);
        $post->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $post->execute();
        $post->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, MODEL_POST);
        return $post->fetchAll();
    }

    public function countPosts()
    {
        $count = $this->dbConnect()->prepare("SELECT COUNT(id) FROM post WHERE isValid = 1");
        $count->execute();
        $count->setFetchMode(\PDO::FETCH_NUM);
        return $count->fetch();
    }

}

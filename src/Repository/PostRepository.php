<?php

namespace App\Repository;

use App\PHPClass\DbManager;
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

    public function getAllPost($perPage, $offset)
    {
        $post = $this->dbConnect()->prepare("SELECT post.id, user.firstname, post.title, post.lead, post.createdAt FROM 
                                            post, user WHERE post.idUser = user.id ORDER BY post.id DESC LIMIT :perPage OFFSET :offset ");
        $post->bindValue(':perPage', $perPage, \PDO::PARAM_INT);
        $post->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $post->execute();
        $post->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');
        return $post->fetchAll();
    }

    public function countPosts()
    {
        $count = $this->dbConnect()->prepare("SELECT COUNT(id) FROM post");
        $count->execute();
        $count->setFetchMode(\PDO::FETCH_NUM);
        return $count->fetch();
    }

    public function getUnvalidatedPost()
    {
        $post = $this->dbConnect()->prepare("SELECT user.pseudo, post.title, post.createdAt FROM post, user WHERE post.idUser = user.id AND post.isValid = 0 ORDER BY post.id LIMIT 5");
        $post->execute();
        $post->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');
        return $post->fetchAll();
    }
    public function countUnvalidatedPost()
    {
        $count = $this->dbConnect()->prepare("SELECT COUNT(id) FROM post WHERE isValid = 0");
        $count->execute();
        $count->setFetchMode(\PDO::FETCH_NUM);
        return $count->fetch();
    }
    public function getUnvalidatedAnswer()
{
    $post = $this->dbConnect()->prepare("SELECT user.pseudo, answer.answer, answer.createdAt FROM answer, user WHERE answer.idUser = user.id AND answer.isValid = 0 ORDER BY answer.id LIMIT 5");
    $post->execute();
    $post->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');
    return $post->fetchAll();
}
    public function countUnvalidatedAnswer()
    {
        $count = $this->dbConnect()->prepare("SELECT COUNT(id) FROM answer WHERE isValid = 0");
        $count->execute();
        $count->setFetchMode(\PDO::FETCH_NUM);
        return $count->fetch();
    }

}

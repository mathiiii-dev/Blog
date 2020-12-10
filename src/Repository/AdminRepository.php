<?php

namespace App\Repository;

use App\Services\DbManager;

class AdminRepository extends dbManager
{
    public function getUnvalidatedPost(): array
    {
        $post = $this->dbConnect()->prepare("SELECT post.id, user.pseudo, post.content, post.createdAt FROM post, 
                                    user WHERE post.idUser = user.id AND post.isValid = 0 ORDER BY post.id DESC LIMIT 5");
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

    public function validatePostRepo(int $idPost): void
    {
        $modifyPost = $this->dbConnect()->prepare(
            'UPDATE Post SET isValid = 1 WHERE id = :idPost'
        );

        $modifyPost->bindValue(':idPost', $idPost, \PDO::PARAM_INT);
        $modifyPost->execute();
    }

    public function getUnvalidatedAnswer(): array
    {
        $post = $this->dbConnect()->prepare("SELECT answer.id, user.pseudo, answer.idPost, answer.answer, answer.createdAt 
                                    FROM answer, user WHERE answer.idUser = user.id AND answer.isValid = 0 ORDER BY answer.id DESC LIMIT 5");
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

    public function validateAnswerRepo(int $idAnswer): void
    {
        $modifyPost = $this->dbConnect()->prepare(
            'UPDATE Answer SET isValid = 1 WHERE id = :idAnswer'
        );
        $modifyPost->bindValue(':idAnswer', $idAnswer, \PDO::PARAM_INT);
        $modifyPost->execute();
    }
}
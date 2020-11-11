<?php

namespace App\Model\Repository;

use App\Model\Answer;
use App\Model\DbManager;

class AnswerRepository extends DbManager
{
    public function __construct()
    {
        $this->dbConnect();
    }

    public function addAnswer(Answer $answer)
    {
        $addAnswer = $this->dbConnect()->prepare(
            'INSERT INTO Answer (idPost, idUser, answer, createdAt, isValid) 
            VALUES (:idPost, :idUser, :answer, :createdAt, :isValid)'
        );

        $addAnswer->bindValue(':idUser', $answer->getIdUser(), \PDO::PARAM_INT);
        $addAnswer->bindValue(':idPost', $answer->getIdPost(), \PDO::PARAM_INT);
        $addAnswer->bindValue(':answer', $answer->getAnswer(), \PDO::PARAM_STR);
        $addAnswer->bindValue(':createdAt', $answer->getCreatedAt(), \PDO::PARAM_STR);
        $addAnswer->bindValue(':isValid', $answer->getIsValid(), \PDO::PARAM_INT);
        $addAnswer->execute();
    }

    public function getAllAnswerFromOnePost($answer)
    {
        $answer = $this->dbConnect()->prepare("SELECT answer.id, answer.answer, answer.createdAt, user.firstname FROM answer INNER JOIN post ON post.id = answer.idPost INNER JOIN user ON user.id = answer.idUser ");
        $answer->execute();
        $answer->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');
        return $answer->fetchAll();
    }
}

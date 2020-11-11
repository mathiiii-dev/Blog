<?php

namespace App\Model;

class Answer extends Model
{
    protected int $id, $idUser, $idPost, $isValid;
    protected string $answer, $createdAt, $updatedAt;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdUser() : int
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function getIdPost() : int
    {
        return $this->idPost;
    }

    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;
    }

    public function getIsValid() : int
    {
        return $this->isValid;
    }

    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    public function getAnswer() : string
    {
        return $this->answer;
    }

    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    public function getCreatedAt() : string
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdateAt() : string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}

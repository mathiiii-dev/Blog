<?php

namespace App\Model;

class Post extends Model
{
    protected int $id, $idUser, $isValid;
    protected string $title, $lead, $content, $createdAt;

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

    public function getIsValid() : int
    {
        return $this->isValid;
    }

    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getLead() : string
    {
        return $this->lead;
    }

    public function setLead($lead)
    {
        $this->lead = $lead;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getCreatedAt() : string
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
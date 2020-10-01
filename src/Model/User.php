<?php

namespace App\Model;

class User extends Model
{
    protected int $id;
    protected string $firstname,
                     $lastname,
                     $email,
                     $pseudo,
                     $password,
                     $type,
                     $createdAt;


    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId($id) : int
    {
        $this->id = $id;
    }

    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname) : string
    {
        $this->firstname = $firstname;
    }

    public function getLastname() : string
    {
        return $this->firstname;
    }

    public function setLastname($lastname) : string
    {
        $this->lastname = $lastname;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail($email) : string
    {
        $this->email = $email;
    }

    public function getPseudo() : string
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPassword($password) : string
    {
        $this->password = $password;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function setType($type) : string
    {
        $this->type = $type;
    }

    public function getCreatedAt() : string
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) : string
    {
        $this->createdAt = $createdAt;
    }
}

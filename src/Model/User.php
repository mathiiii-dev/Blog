<?php

namespace App\Model;

class User
{
    protected int $id;
    protected string $firstname,
                     $lastname,
                     $email,
                     $pseudo,
                     $password,
                     $type;

    public function __construct($id, $firstname, $lastname, $email, $pseudo, $password,$type)
    {
        $this->id=$id;
        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->pseudo=$pseudo;
        $this->email=$email;
        $this->password=$password;
        $this->type=$type;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function getLastname() : string
    {
        return $this->firstname;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPseudo() : string
    {
        return $this->pseudo;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getType() : string
    {
        return $this->type;
    }

}

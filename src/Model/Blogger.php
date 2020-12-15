<?php


namespace App\Model;


class Blogger extends Model
{
    protected int $idUser;
    protected string $description, $country, $profilePicture;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setProfilePicture(string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

}

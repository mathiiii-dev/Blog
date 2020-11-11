<?php


namespace App\Model;


class Blogger extends Model
{
    protected int $idUser;
    protected string $description, $country, $numTel, $profilePicture;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $numTel
     */
    public function setNumTel(string $numTel): void
    {
        $this->numTel = $numTel;
    }

    /**
     * @return string
     */
    public function getNumTel(): string
    {
        return $this->numTel;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture(string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return string
     */
    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

}
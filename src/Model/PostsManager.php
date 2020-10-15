<?php


namespace App\Model;


class PostsManager
{
    public function isNotEmpty(Post $post) : bool
    {
        $title = $post->getTitle();
        $lead = $post->getLead();
        $content = $post->getContent();
        $createdAt = $post->getCreatedAt();
        $idUser = $post->getIdUser();
        $isValid = $post->getIsValid();

        if (empty($title) && empty($lead) && empty($content) && empty($createdAt)) {
            return false;
        }

        return true;
    }

    public function checkLength(int $length, string $input)
    {

        if (strlen($input) < $length){
            return false;
        }
        return true;
    }
}
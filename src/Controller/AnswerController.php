<?php


namespace App\Controller;


use App\Model\Answer;
use App\Model\Repository\AnswerRepository;

class AnswerController
{
    public function createAnswer($id)
    {
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $answer = new Answer([
            'answer' => $_POST['answer'],
            'createdAt' => date('y-m-d'),
            'idUser' => $_SESSION['id'] ?? $cookie[0],
            'idPost' => $id,
            'isValid' => 0
        ]);

        $answerRepo = new AnswerRepository();
        $answerRepo->addAnswer($answer);
        header('Location: /Blog/posts/'.$id);
    }
}
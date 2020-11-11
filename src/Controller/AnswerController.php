<?php


namespace App\Controller;


use App\Model\Answer;
use App\Model\Repository\AnswerRepository;
use App\Model\Twig;

class AnswerController extends Twig
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

    public function showModifyAnswer($id)
    {
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $answerRepo = new AnswerRepository();
        $idUserAnswer = $answerRepo->getIdUserFromAnswer($id);
        if (empty($cookie[0]) && empty($_SESSION['id']) || $idUserAnswer['idUser'] != $_SESSION['id'] ?? $cookie[0]) {
            http_response_code(500);
            return $this->twig('500.html.twig', ['' => '']);
        }
        $this->twig('modifyAnswer.html.twig',
            [
                'answerModif' => $idUserAnswer['answer'],
                'answerId' => $idUserAnswer['id']
            ]);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $answer = new Answer([
                'answer' => $_POST['answer'],
                'updatedAt' => date('y-m-d')
            ]);

           $answerRepo->modifyAnswer($id, $answer);
           header('Location: /Blog/posts/'.$idUserAnswer['idPost']);
        }
    }
  
    public function deleteAnswer(int $id)
    {
        $answer = new AnswerRepository();
        $answerInfo = $answer->getAnswerById($id);
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        if (empty($cookie[0]) && empty($_SESSION['id']) || $answerInfo['idUser'] != $_SESSION['id'] ?? $cookie[0]) {
            http_response_code(500);
            return $this->twig('500.html.twig', ['' => '']);
        }
        $answer->deleteAnswer($id);
        header('Location: /Blog/posts/'.$answerInfo['idPost']);

    }
}

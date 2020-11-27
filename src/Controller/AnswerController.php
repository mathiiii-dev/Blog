<?php

namespace App\Controller;

use App\Model\Answer;
use App\Services\MessageFlash;
use App\Repository\AnswerRepository;
use App\Services\Twig;

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
        if (http_response_code(200)) {
            $session = new MessageFlash();
            $session->setFlashMessage('Votre réponse a bien été créée !', 'alert alert-success');
        }
        header('Location: /Blog/post/' . $id);
    }

    public function modifyAnswer($id)
    {
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $answerRepo = new AnswerRepository();
        $idUserAnswer = $answerRepo->getIdUserFromAnswer($id);
        if (empty($cookie[0]) && empty($_SESSION['id']) || $idUserAnswer['idUser'] != $_SESSION['id'] ?? $cookie[0]) {
            http_response_code(500);
            return $this->twig('500.html.twig');
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
            $session = new MessageFlash();
            $session->setFlashMessage('Votre réponse a bien été modifiée !', 'alert alert-success');
            $answerRepo->modifyAnswer($id, $answer);
            header('Location: /Blog/post/' . $idUserAnswer['idPost']);
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
            return $this->twig('500.html.twig');
        }
        $session = new MessageFlash();
        $session->setFlashMessage('Votre réponse a bien été supprimée !', 'alert alert-success');
        $answer->deleteAnswer($id);
        header('Location: /Blog/post/' . $answerInfo['idPost']);

    }
}

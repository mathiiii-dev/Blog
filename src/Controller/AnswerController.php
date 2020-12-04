<?php

namespace App\Controller;

use App\Model\Answer;
use App\Services\AccessValidator;
use App\Services\FormValidator;
use App\Services\MessageFlash;
use App\Repository\AnswerRepository;
use App\Services\Twig;

class AnswerController extends Twig
{
    public function createAnswer(int $id)
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
        $formValidator = new FormValidator();
        if ($formValidator->checkAnswer($_POST['answer'])) {
            $answerRepo->addAnswer($answer);
            $session = new MessageFlash();
            $session->setFlashMessage('Votre réponse a bien été créée ! Elle sera visible lorsque la modération l\'aura validée.', 'success');
        }

        header('Location: /Blog/post/' . $id);
    }

    public function modifyAnswer(int $id)
    {
        $answerRepo = new AnswerRepository();
        $idUserAnswer = $answerRepo->getIdUserFromAnswer($id);
        $verifAccess = new AccessValidator();
        if (!$verifAccess->isValid($idUserAnswer['idUser'] ?? null)) {
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
            $session->setFlashMessage('Votre réponse a bien été modifiée !', 'success');
            $answerRepo->modifyAnswer($id, $answer);
            header('Location: /Blog/post/' . $idUserAnswer['idPost']);
        }
    }

    public function deleteAnswer(int $id)
    {
        $answer = new AnswerRepository();
        $answerInfo = $answer->getAnswerById($id);
        $verifAccess = new AccessValidator();
        if (!$verifAccess->isValid($answerInfo['idUser'] ?? null)) {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }
        $session = new MessageFlash();
        $session->setFlashMessage('Votre réponse a bien été supprimée !', 'success');
        $answer->deleteAnswer($id);
        header('Location: /Blog/post/' . $answerInfo['idPost']);

    }
}

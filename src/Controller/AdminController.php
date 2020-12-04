<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Services\AccessValidator;
use App\Services\MessageFlash;
use App\Services\Twig;
use App\Repository\AdminRepository;
use App\Repository\AnswerRepository;
use App\Repository\PostRepository;

class AdminController extends Twig
{
    public function show(): void
    {

        $cookie = $_COOKIE['auth'] ?? null;
        $cookieId = explode('-----', $cookie);
        $userRepo = new UserRepository();
        $userType = $userRepo->getUserById($cookieId[0]);
        $type = $userType['type'] ?? $_SESSION['type'];
        $adminAccess = new AccessValidator();
        if($adminAccess->isValidAdmin($type)){
            $session = new MessageFlash();
            $flash = $session->showFlashMessage();
            $adminRepo = new AdminRepository();
            $unvalidatedPost = $adminRepo->getUnvalidatedPost();
            $countUnvalidatedPost = $adminRepo->countUnvalidatedPost();
            $unvalidatedAnswer = $adminRepo->getUnvalidatedAnswer();
            $countUnvalidatedAnswer = $adminRepo->countUnvalidatedAnswer();
            $this->twig('admin.html.twig', [
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null,
                'posts' => $unvalidatedPost,
                'countUnvalidatedPost' => $countUnvalidatedPost[0],
                'answers' => $unvalidatedAnswer,
                'countUnvalidatedAnswer' => $countUnvalidatedAnswer[0]
            ]);
        }

    }

    public function validatePost(int $idPost): void
    {
        $type = $_SESSION['type'] ?? null;
        $adminAccess = new AccessValidator();
        if($adminAccess->isValidAdmin($type)) {
            $adminRepo = new AdminRepository();
            $adminRepo->validatePostRepo($idPost);
            header('Location: /Blog/admin');
        }
    }

    public function validateAnswer(int $idAnswer): void
    {
        $type = $_SESSION['type'] ?? null;

        $adminAccess = new AccessValidator();
        if($adminAccess->isValidAdmin($type)) {
            $adminRepo = new AdminRepository();
            $adminRepo->validateAnswerRepo($idAnswer);
            header('Location: /Blog/admin');
        }
    }

    public function deleteAnswer(int $idAnswer): void
    {
        $type = $_SESSION['type'] ?? null;
        $adminAccess = new AccessValidator();
        if($adminAccess->isValidAdmin($type)) {
            $answerRepo = new AnswerRepository();
            $answerRepo->deleteAnswer($idAnswer);
            header('Location: /Blog/admin');
        }
    }

    public function deletePost(int $idPost): void
    {
        $type = $_SESSION['type'] ?? null;
        $adminAccess = new AccessValidator();
        if($adminAccess->isValidAdmin($type)) {
            $postRepo = new PostRepository();
            $postRepo->deletePost($idPost);
            header('Location: /Blog/admin');
        }
    }
}
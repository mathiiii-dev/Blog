<?php

namespace App\Controller;

use App\PHPClass\MessageFlash;
use App\PHPClass\Twig;
use App\Repository\AdminRepository;
use App\Repository\AnswerRepository;
use App\Repository\PostRepository;

class AdminController extends Twig
{
    public function show()
    {
        $type = $_SESSION['type'] ?? null;
        if ($type != "Admin") {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }
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

    public function validatePost($idPost)
    {
        $type = $_SESSION['type'] ?? null;
        if ($type != "Admin") {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }

        $adminRepo = new AdminRepository();
        $adminRepo->validatePostRepo($idPost);
        header('Location: /Blog/admin');
    }

    public function validateAnswer($idAnswer)
    {
        $type = $_SESSION['type'] ?? null;
        if ($type != "Admin") {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }
        $adminRepo = new AdminRepository();
        $adminRepo->validateAnswerRepo($idAnswer);
        header('Location: /Blog/admin');
    }

    public function deleteAnswer($idAnswer)
    {
        $type = $_SESSION['type'] ?? null;
        if ($type != "Admin") {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }
        $answerRepo = new AnswerRepository();
        $answerRepo->deleteAnswer($idAnswer);
        header('Location: /Blog/admin');
    }

    public function deletePost($idPost)
    {
        $type = $_SESSION['type'] ?? null;
        if ($type != "Admin") {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }
        $postRepo = new PostRepository();
        $postRepo->deletePost($idPost);
        header('Location: /Blog/admin');
    }
}
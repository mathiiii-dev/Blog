<?php

namespace App\Controller;

use App\PHPClass\MessageFlash;
use App\PHPClass\Twig;
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
        $postRepo = new PostRepository();
        $unvalidatedPost = $postRepo->getUnvalidatedPost();
        $countUnvalidatedPost = $postRepo->countUnvalidatedPost();
        $unvalidatedAnswer = $postRepo->getUnvalidatedAnswer();
        $countUnvalidatedAnswer = $postRepo->countUnvalidatedAnswer();
        $this->twig('admin.html.twig', [
            'message' => $flash['message'] ?? null,
            'class' => $flash['class'] ?? null,
            'posts' => $unvalidatedPost,
            'countUnvalidatedPost' => $countUnvalidatedPost[0],
            'answers' => $unvalidatedAnswer,
            'countUnvalidatedAnswers' => $countUnvalidatedAnswer[0]
        ]);
    }
}
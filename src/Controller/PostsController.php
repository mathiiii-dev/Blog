<?php

namespace App\Controller;

use App\Model\Post;
use App\Services\FormValidator;
use App\Services\MessageFlash;
use App\Services\Pagination;
use App\Repository\AnswerRepository;
use App\Repository\PostRepository;
use App\Services\Twig;

class PostsController extends Twig
{
    public function show($id)
    {
        $post = new PostRepository();
        $postInfo = $post->getPostById($id);
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        if (!$postInfo) {
            http_response_code(404);
            return $this->twig('404.html.twig');
        }
        $userName = $post->getUserForAPost($id);
        $date = date_create($postInfo['createdAt']);
        $dateFormat = date_format($date, 'd/m/Y');
        $answerRepo = new AnswerRepository();
        $answer = $answerRepo->getAllAnswerFromOnePost($id);
        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->twig('post.html.twig',
            [
                'title' => $postInfo['title'],
                'lead' => $postInfo['lead'],
                'content' => $postInfo['content'],
                'createdAt' => $dateFormat,
                'firstname' => $userName['firstname'],
                'idPost' => $id,
                'idUserSession' => $_SESSION['id'] ?? $cookie[0],
                'idUserPost' => $postInfo['idUser'],
                'answer' => $answer,
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null
            ]);
    }

    public function showAllPosts($page)
    {
        $postRepo = new PostRepository();
        $pagination = new Pagination();
        $paginationConf = $pagination->getPostPagination($page);
        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $postInfo = $postRepo->getAllPost($paginationConf['perPage'] ?? null, $paginationConf['offset'] ?? null);
        $hasPost = true;

        if ($paginationConf['overPage']) {
            http_response_code(404);
            return $this->twig('404.html.twig');
        }

        if (!$postInfo) {
            $hasPost = false;
        }

        $this->twig('posts.html.twig',
            [
                'row' => $postInfo,
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null,
                'currentPage' => $paginationConf['currentPage'] ?? null,
                'pages' => $paginationConf['pages'] ?? null,
                'hasPost' => $hasPost
            ]);
    }

    public function createPost()
    {
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        if (empty($cookie[0]) && empty($_SESSION['id'])) {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }

        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->twig('createPost.html.twig', [
            'message' => $flash['message'] ?? null,
            'class' => $flash['class'] ?? null
        ]);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = new Post([
                'title' => $_POST['title'],
                'lead' => $_POST['lead'],
                'content' => $_POST['content'],
                'createdAt' => date('y-m-d'),
                'idUser' => $_SESSION['id'] ?? $cookie[0],
                'isValid' => 0
            ]);
            $checkPost = new FormValidator();

            if (!$checkPost->checkPost($post)) {
                return header('Location: /Blog/create-post');
            }
            $session = new MessageFlash();
            $session->setFlashMessage('Votre post à bien été créé !', 'alert alert-success');
            $postRepo = new PostRepository();
            $postRepo->addPost($post);
            header('Location: /Blog/posts/1');
        }
    }

    public function modifyPost($id)
    {
        $post = new PostRepository();
        $postInfo = $post->getPostById($id);
        $postRepo = new PostRepository();
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);

        if (empty($cookie[0]) && empty($_SESSION['id']) || $postInfo['idUser'] != $_SESSION['id'] ?? $cookie[0]) {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }

        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->twig('modifyPost.html.twig',
            [
                'title' => $postInfo['title'],
                'lead' => $postInfo['lead'],
                'content' => $postInfo['content'],
                'idPost' => $id,
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null
            ]);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($postInfo['idUser'] != $_SESSION['id'] ?? $cookie[0]) {
                http_response_code(500);
                return $this->twig('500.html.twig');
            }

            $post = new Post([
                'title' => $_POST['title'],
                'lead' => $_POST['lead'],
                'content' => $_POST['content'],
                'updatedAt' => date('y-m-d'),
                'idUser' => $postInfo['idUser'],
                'createdAt' => $postInfo['createdAt'],
                'isValid' => 0
            ]);

            $checkPost = new FormValidator();

            if (!$checkPost->checkPost($post)) {
                return header('Location: /Blog/modify-post/' . $id);
            }
            $session = new MessageFlash();
            $session->setFlashMessage('Votre post à bien été modifié !', 'alert alert-success');
            $postRepo->modifyPost($id, $post);
            header('Location: /Blog/post/' . $id);
        }
    }

    public function deletePost(int $id)
    {
        $post = new PostRepository();
        $postInfo = $post->getPostById($id);
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        if (empty($cookie[0]) && empty($_SESSION['id']) || $postInfo['idUser'] != $_SESSION['id'] ?? $cookie[0]) {
            http_response_code(500);
            return $this->twig('500.html.twig', ['' => '']);
        }
        $session = new MessageFlash();
        $session->setFlashMessage('Votre post à bien été supprimé !', 'alert alert-success');
        $postRepo = new PostRepository();
        $postRepo->deletePost($id);
        header('Location: /Blog/posts/1');
    }
}

<?php

namespace App\Controller;

use App\Model\Post;
use App\Repository\{UserRepository, AnswerRepository, PostRepository};
use App\Services\{AccessValidator, FormValidator, MessageFlash, Pagination, Twig};

class PostsController extends Twig
{
    public function show(int $id)
    {
        $post = new PostRepository();
        $postInfo = $post->getPostById($id);
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        if (!$postInfo) {
            http_response_code(404);
            $this->renderView('404.html.twig');
            exit();
        }
        $userName = $post->getUserForAPost($id);
        $answerRepo = new AnswerRepository();
        $answer = $answerRepo->getAllAnswerFromOnePost($id);
        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->renderView(
            'post.html.twig',
            [
                'title' => $postInfo['title'],
                'lead' => $postInfo['lead'],
                'content' => $postInfo['content'],
                'createdAt' => $postInfo['createdAt'],
                'updatedAt' => $postInfo['updatedAt'],
                'pseudo' => $userName,
                'idPost' => $id,
                'idUserSession' => $_SESSION['id'] ?? $cookie[0],
                'idUserPost' => $postInfo['idUser'],
                'answer' => $answer,
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null
            ]
        );
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

        if (!$postInfo) {
            $hasPost = false;
        } else if ($paginationConf['overPage']) {
            http_response_code(404);
            $this->renderView('404.html.twig');
            exit();
        }

        $this->renderView(
            'posts.html.twig',
            [
                'row' => $postInfo,
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null,
                'currentPage' => $paginationConf['currentPage'] ?? null,
                'pages' => $paginationConf['pages'] ?? null,
                'hasPost' => $hasPost
            ]
        );
    }

    public function createPost()
    {
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $verifAccess = new AccessValidator();
        if ($verifAccess->isValid($_SESSION['id'] ?? $cookie[0]) === false) {
            http_response_code(500);
            $this->renderView(ERR_500);
            exit();
        }

        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->renderView(
            'createPost.html.twig', [
            'message' => $flash['message'] ?? null,
            'class' => $flash['class'] ?? null
            ]
        );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = new Post(
                [
                'title' => $_POST['title'],
                'lead' => $_POST['lead'],
                'content' => $_POST['content'],
                'createdAt' => date('y-m-d'),
                'idUser' => $_SESSION['id'] ?? $cookie[0],
                'isValid' => 0
                ]
            );
            $checkPost = new FormValidator();

            if (!$checkPost->checkPost($post)) {
                header('Location: /Blog/create-post');
                exit();
            }

            $session = new MessageFlash();
            $session->setFlashMessage('Votre post a bien été créé ! Il sera visible lorsque la modération l\'aura validée.', 'success');
            $postRepo = new PostRepository();
            $postRepo->addPost($post);
            header(POSTS.'/1');
        }
    }

    public function modifyPost(int $id)
    {
        $post = new PostRepository();
        $postRepo = new PostRepository();
        $userRepo = new UserRepository();
        $verifAccess = new AccessValidator();
        $session = new MessageFlash();
        $postInfo = $post->getPostById($id);
        $flash = $session->showFlashMessage();
        $usersPseudo = $userRepo->getAllUserPseudo();

        if (!$verifAccess->isValid($postInfo['idUser'] ?? null)) {
            http_response_code(500);
            $this->renderView(ERR_500);
            exit();
        }
        $this->renderView(
            'modifyPost.html.twig',
            [
                'title' => $postInfo['title'],
                'lead' => $postInfo['lead'],
                'content' => $postInfo['content'],
                'idPost' => $id,
                'authors' => $usersPseudo,
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null
            ]
        );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = new Post(
                [
                'title' => $_POST['title'],
                'lead' => $_POST['lead'],
                'content' => $_POST['content'],
                'updatedAt' => date('y-m-d'),
                'idUser' => $_POST['author'],
                'createdAt' => $postInfo['createdAt'],
                'isValid' => 0
                ]
            );

            $checkPost = new FormValidator();

            if (!$checkPost->checkPost($post)) {
                header('Location: /Blog/modify-post/' . $id);
                exit();
            }
            $session = new MessageFlash();
            $session->setFlashMessage('Votre post a bien été modifié !', 'alert alert-success');
            $postRepo->modifyPost($id, $post);
            header(POST . '/' .$id);
        }
    }

    public function deletePost(int $id)
    {
        $post = new PostRepository();
        $postInfo = $post->getPostById($id);
        $verifAccess = new AccessValidator();

        if (!$verifAccess->isValid($postInfo['idUser'] ?? null)) {
            http_response_code(500);
            $this->renderView(ERR_500);
            exit();
        }
        $session = new MessageFlash();
        $session->setFlashMessage('Votre post a bien été supprimé !', 'alert alert-success');
        $postRepo = new PostRepository();
        $postRepo->deletePost($id);
        header(POSTS.'/1');
    }
}

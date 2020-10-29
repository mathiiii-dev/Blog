<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\PostsManager;
use App\Model\Repository\PostRepository;
use App\Model\Repository\UserRepository;
use App\Model\Twig;

class PostsController extends Twig
{
    public function show($id, string $filter = null)
    {
        session_start();
        $post = new PostRepository();
        $postInfo = $post->getPostById($id);
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        if (!$postInfo) {
            http_response_code(404);
            $this->twig('404.html.twig', ['' => '' . $filter . '']);
        }else {
            $userName = $post->getUserForAPost($id);
            $date = date_create($postInfo['createdAt']);
            $dateFormat = date_format($date, 'd/m/Y');
            $this->twig('post.html.twig',
                [
                    'erreur' => $filter,
                    'title' => $postInfo['title'],
                    'lead' => $postInfo['lead'],
                    'content' => $postInfo['content'],
                    'createdAt' => $dateFormat,
                    'firstname' => $userName['firstname'],
                    'idPost' => $id,
                    'idUserSession' => $_SESSION['id'] ?? $cookie[0],
                    'idUserPost' => $postInfo['idUser']
                ]);
        }

    }

    public function showAllPosts(string $filter = null)
    {
        $this->twig('posts.html.twig', ['' => '' . $filter . '']);
    }

    public function showCreatePost(string $filter = null)
    {
        session_start();
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        if (empty($cookie[0]) && empty($_SESSION['id'])){
            http_response_code(500);
            $this->twig('500.html.twig', ['' => '' . $filter . '']);
        }else {
            $this->twig('createPost.html.twig', ['erreur' => '' . $filter . '']);
        }
    }

    public function createPost()
    {
        session_start();
        $cookie = $_COOKIE['auth'];
        $cookie = explode('-----', $cookie);
        if (empty($cookie[0]) && empty($_SESSION['id'])){
            http_response_code(500);
            $this->twig('500.html.twig', ['' => '']);
        }else {
            $post = new Post([
                'title' => $_POST['title'],
                'lead' => $_POST['lead'],
                'content' => $_POST['content'],
                'createdAt' => date('y-m-d'),
                'idUser' => $_SESSION['id'] ?? $cookie[0],
                'isValid' => 0
            ]);
            $postManager = new PostsManager();
            if (!$postManager->isNotEmpty($post)) {
                $this->showCreatePost('Veuillez remplir tout les champs');
            }
            if ($postManager->checkLength(50, $_POST['title'])) {
                $this->showCreatePost('Le titre est trop long');
            }
            if ($postManager->checkLength(100, $_POST['lead'])) {
                $this->showCreatePost('Le chapô est trop long');
            } else {
                $postRepo = new PostRepository();
                $postRepo->addPost($post);
                header('Location: posts');
            }
        }
    }
}

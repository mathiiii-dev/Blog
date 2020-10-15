<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\Repository\PostRepository;
use App\Model\Twig;

class PostsController extends Twig
{
    public function show($id, string $filter = null)
    {
        $post = new PostRepository();
        $postInfo = $post->getPostById($id);
        $date = date_create($postInfo['createdAt']);
        $dateFormat = date_format($date, 'd/m/Y');
        $this->twig('post.html.twig',
            [
                'erreur'=>''.$filter.'',
                'title'=>''.$postInfo['title'].'',
                'lead'=>''.$postInfo['lead'].'',
                'content' => ''.$postInfo['content'].'',
                'createdAt' => ''.$dateFormat.''
            ]);
    }

    public function showAllPosts(string $filter = null)
    {
        $this->twig('posts.html.twig', ['' => ''.$filter.'']);
    }

    public function showCreatePost(string $filter = null)
    {
        $this->twig('createPost.html.twig', ['' => ''.$filter.'']);
    }

    public function createPost()
    {
        $post = new Post([
            'title' => $_POST['title'],
            'lead' => $_POST['lead'],
            'content' => $_POST['content'],
            'createdAt' => date('y-m-d')
        ]);
    }
}

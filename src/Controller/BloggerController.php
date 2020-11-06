<?php


namespace App\Controller;


use App\Model\Blogger;
use App\Model\Repository\BloggerRepository;
use App\Model\Twig;

class BloggerController extends Twig
{

    public function show(int $id)
    {
        $bloggerRepo = new BloggerRepository();
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $bloggerInfo = $bloggerRepo->getInfoBloggerById($id);
        $bloggerPost = $bloggerRepo->getPostsFromBlogger($id);
        if (!$bloggerInfo) {
            http_response_code(404);
            return $this->twig('404.html.twig');
        } else {
            $this->twig('profil.html.twig',
                [
                    'idUserBlogger' => $id,
                    'idUserSession' => $_SESSION['id'] ?? $cookie[0],
                    'pseudo' => $bloggerInfo["pseudo"],
                    'description' => $bloggerInfo["description"],
                    'country' => $bloggerInfo["country"],
                    'profilePicture' => $bloggerInfo["profilePicture"],
                    'posts' => $bloggerPost
                ]);
        }
    }

    public function modifyProfil(int $id)
    {
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $bloggerRepo = new BloggerRepository();
        $bloggerInfo = $bloggerRepo->getInfoBloggerById($id);
        if (empty($cookie[0]) && empty($_SESSION['id']) || $bloggerInfo['idUser'] != $_SESSION['id'] ?? $cookie[0]) {
            http_response_code(500);
            return $this->twig('500.html.twig', ['' => '']);
        }

        $this->twig('modifyProfil.html.twig',
            [
                'description' => $bloggerInfo['description'],
                'country' => $bloggerInfo['country'],
                'profilePicture' => $bloggerInfo['profilePicture'],
            ]);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $blogger = new Blogger([
                'description' => $_POST['description'],
                'country' => $_POST['country'],
                'profilePicture' => $_POST['image'].'.'.'png',
            ]);

            $bloggerRepo->modifyProfil($id, $blogger);
            header('Location: /Blog/profil/'.$id);

        }
    }

}
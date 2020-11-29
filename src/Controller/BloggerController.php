<?php

namespace App\Controller;

use App\Model\Blogger;
use App\Services\AccessValidator;
use App\Services\Country;
use App\Services\MessageFlash;
use App\Repository\BloggerRepository;
use App\Services\Twig;

class BloggerController extends Twig
{

    public function show(int $id)
    {
        $bloggerRepo = new BloggerRepository();
        $bloggerInfo = $bloggerRepo->getInfoBloggerById($id);

        if (!$bloggerInfo) {
            http_response_code(404);
            return $this->twig('404.html.twig');
        }

        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $bloggerPost = $bloggerRepo->getPostsFromBlogger($id);
        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->twig('profil.html.twig',
            [
                'idUserBlogger' => $id,
                'idUserSession' => $_SESSION['id'] ?? $cookie[0],
                'pseudo' => $bloggerInfo["pseudo"],
                'description' => $bloggerInfo["description"],
                'country' => $bloggerInfo['country'],
                'profilePicture' => $bloggerInfo["profilePicture"] . '.png',
                'posts' => $bloggerPost,
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null
            ]);
    }

    public function modifyProfil(int $id)
    {
        $bloggerRepo = new BloggerRepository();
        $bloggerInfo = $bloggerRepo->getInfoBloggerById($id);
        $verifAccess = new AccessValidator();
        if (!$verifAccess->validAccess($bloggerInfo['idUser'])) {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $blogger = new Blogger([
                'description' => $_POST['description'] ?? '',
                'country' => $_POST['country'] ?? '',
                'profilePicture' => $_POST['image'] ?? '',
            ]);
            $session = new MessageFlash();
            $session->setFlashMessage('Votre profil a bien été modifié !', 'success');
            $bloggerRepo->modifyProfil($id, $blogger);
            header('Location: /Blog/profil/' . $id);
        }
        $country = new Country();
        $code = $country->getCountryCode();
        $this->twig('modifyProfil.html.twig',
            [
                'description' => $bloggerInfo['description'],
                'profilePicture' => $bloggerInfo['profilePicture'],
                'country' => $code,
            ]);
    }

}
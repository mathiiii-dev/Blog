<?php

namespace App\Controller;

use App\Model\Blogger;
use App\Services\{AccessValidator, Country, FormValidator, MessageFlash, Twig};
use App\Repository\BloggerRepository;

class BloggerController extends Twig
{

    public function show(int $id)
    {
        $bloggerRepo = new BloggerRepository();
        $bloggerInfo = $bloggerRepo->getInfoBloggerById($id);

        if (!$bloggerInfo) {
            http_response_code(404);
            $this->renderView('404.html.twig');
            exit();
        }

        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $bloggerPost = $bloggerRepo->getPostsFromBlogger($id);
        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->renderView('profil.html.twig',
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
        $session = new MessageFlash();

        if (!$verifAccess->isValid($bloggerInfo['idUser'])) {
            http_response_code(500);
            $this->renderView('500.html.twig');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $blogger = new Blogger([
                'description' => $_POST['description'] ?? '',
                'country' => $_POST['country'] ?? '',
                'profilePicture' => $_POST['image'] ?? '',
            ]);
            $checkForm = new FormValidator();

            if (!$checkForm->checkModifProfile($_POST)) {
                header('Location: /Blog/modify-profil/' . $id);
                exit();
            }
            $session->setFlashMessage('Votre profil a bien été modifié !', 'success');
            $bloggerRepo->modifyProfil($id, $blogger);
            header('Location: /Blog/profil/' . $id);
        }
        $country = new Country();
        $code = $country->getCountryCode();
        $flash = $session->showFlashMessage();
        $this->renderView('modifyProfil.html.twig',
            [
                'description' => $bloggerInfo['description'],
                'profilePicture' => $bloggerInfo['profilePicture'],
                'country' => $code,
                'message' => $flash['message'] ?? null,
                'class' => $flash['class'] ?? null
            ]);
    }

}
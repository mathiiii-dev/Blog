<?php

namespace App\Controller;

use App\Services\Twig;
use App\Services\MessageFlash;

class HomeController extends Twig
{

    public function show()
    {
        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->renderView(
            'home.html.twig', [
            'message' => $flash['message'] ?? null,
            'class' => $flash['class'] ?? null
            ]
        );
    }
}

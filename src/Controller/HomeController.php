<?php

namespace App\Controller;

use App\Model\Twig;

class HomeController extends Twig
{
    public function show() : void
    {
        $this->twig('home.html.twig', [''=>'']);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{

    public function __invoke()
    {
        return $this->render('home.html.twig');
    }
}

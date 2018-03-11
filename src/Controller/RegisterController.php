<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegisterController extends Controller
{
    public function __invoke()
    {
        return $this->render('register.html.twig');
    }
}

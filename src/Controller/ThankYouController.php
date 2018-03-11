<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ThankYouController extends Controller
{
    public function __invoke()
    {
        return $this->render('thankyou.html.twig');
    }
}

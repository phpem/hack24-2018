<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DistributeController extends Controller
{
    public function __invoke()
    {
        return $this->render('distribute.html.twig');
    }
}
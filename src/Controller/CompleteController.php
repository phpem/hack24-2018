<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompleteController extends Controller
{
    public function __invoke()
    {
        return $this->redirectToRoute('transaction.list');
    }
}

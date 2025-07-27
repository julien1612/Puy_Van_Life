<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CharterController extends AbstractController
{
    #[Route('/charter', name: 'charter_app')]
    public function index(): Response
    {
        return $this->render('charter/charte.html.twig');
    }
}

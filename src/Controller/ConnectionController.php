<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConnectionController extends AbstractController
{
    #[Route('/connection', name: 'connexion_app')]
    public function index(): Response
    {
        return $this->render('connection/connexion.html.twig');
    }
}

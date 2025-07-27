<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class adminController extends AbstractController
{
    #[Route('/admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}

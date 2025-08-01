<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'evenements_app')]
    public function index(
        EventRepository $eventRepository,
    ): Response
    {
        $event = $eventRepository->findAll();
        return $this->render('event/evenements.html.twig', [
            'events' => $event,
        ]);

    }
}

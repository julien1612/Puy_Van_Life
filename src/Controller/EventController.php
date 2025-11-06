<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'evenements_app')]
    public function index(PaginatorInterface $paginator,
                          Request $request,
                          EventRepository $eventRepository
    ): Response
    {
        $event = $paginator->paginate(
            $eventRepository->findAll(),
            $request->query->getInt('page', 1),
            5

        );
        return $this->render('event/evenements.html.twig', [
            'events' => $event,
        ]);

    }
}

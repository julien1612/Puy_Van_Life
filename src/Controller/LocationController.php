<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LocationController extends AbstractController
{

    #[Route('/location', name: 'spots_app')]
    public function index(
        LocationRepository  $locationRepository,
        SerializerInterface $serializer,
    ): Response
    {
        $locations = $locationRepository->findAll();
        return $this->render('location/spots.html.twig', [
            'locations' => $locations,
            'jsonLocations' => $serializer->serialize(
                $locations,
                'json',
                ['groups' => ['id', 'description', 'latitude', 'longitude', 'address', 'createdAt', 'price', 'type', 'imagePath']]
            ),
        ]);
    }

}

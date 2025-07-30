<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\FavoriteLocation;
use App\Entity\User;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    //5
    #[Route('/favorite/{idLocation}', name: 'favorite_app')]
    public function addToFavorite(
        int $idLocation,
        LocationRepository  $locationRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $location = $locationRepository->find($idLocation);

        if ($user === null) {
            return new Response('User non connecté', Response::HTTP_EXPECTATION_FAILED);
        }
        if ($location === null) {
            return new Response('location not found', Response::HTTP_NOT_FOUND);
        }

        foreach ($user->getFavoriteLocations() as $favoriteLocation)
        {
            if ($favoriteLocation->getLocation()->getId() === $location->getId())
            {
                $entityManager->remove($favoriteLocation);
                $entityManager->flush();

                return new Response('favorite removed', Response::HTTP_OK);
            }
        }

        $favorite = new FavoriteLocation();
        $favorite->setLocation($location);
        $favorite->setUser($user);
        $favorite->setCreatedAt(new \DateTime());

        $entityManager->persist($favorite);
        $entityManager->flush();

        return new Response('favorite created', Response::HTTP_CREATED);

    }



}

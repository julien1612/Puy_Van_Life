<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\FavoriteLocationRepository;
use App\Repository\LocationRepository;
use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(
        FavoriteLocationRepository $favoriteLocationRepository,
        PictureRepository $pictureRepository,
        LocationRepository $locationRepository
    ): Response
    {
        $user = $this->getUser();
        $location = null;
        $pictures = [];
        $favoritelocation = $favoriteLocationRepository->findByFavoriteLocation();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $locationsCollection = $user->getLocations();

        $location = $locationsCollection->first();

        if ($location) {
            $pictures = $pictureRepository->findBy(['location' => $location->getId()]);
        }

        return $this->render('security/profile.html.twig', [
            'favoriteLocations' => $favoritelocation,
            'pictures' => $pictures,
            'location' => $location,
        ]);
    }
}

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
    #[Route('/profile',  name: 'app_profile')]
    public function index(?int $id,
                            FavoriteLocationRepository $favoriteLocationRepository,
                            PictureRepository $pictureRepository


    ): Response
    {
        $pictures = $pictureRepository->findBy(['location' => $id]);

        $favoriteLocation = $favoriteLocationRepository->findByFavoriteLocation();
//        dd($favoriteLocation);


        return $this->render('security/profile.html.twig',[
            'favoriteLocations' => $favoriteLocation,
            'pictures' => $pictures
            ]);

    }
}

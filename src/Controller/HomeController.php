<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\LocationRepository;
use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use App\Service\MeteoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController

{

    public function __construct(
        private MeteoService $meteoService,

    )
    {
    }


    #[Route('/', name: 'app_home')]
    public function index(?int $userId = null,
        LocationRepository $locationRepository,
        PictureRepository  $pictureRepository,
        UserRepository $userRepository

    ): Response
    {
        //Récupère les données météo via un service dédié
        $weatherData = $this->meteoService->findByLocalWeather();

        // Récupère les photos
        $pictures = $pictureRepository->findByPictures(1);

        // Trouve un utilisateur par son ID
        $user = $userRepository->findOneBy(['id' => $userId]);

        // Récupère les trois dernières localisations
        $lastLocation = $locationRepository->findByLastLocation(3);


        return $this->render('home/index.html.twig', [
            'lastLocation' => $lastLocation,
            'pictures' => $pictures,
            'weather' => $weatherData,
            'user' => $user
        ]);
    }
}

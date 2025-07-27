<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\LocationRepository;
use App\Repository\PictureRepository;
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
    public function index(
        LocationRepository $locationRepository,
        PictureRepository  $pictureRepository

    ): Response
    {
        $weatherData = $this->meteoService->findByLocalWeather();

        $pictures = $pictureRepository->findByPictures(1);
        $lastLocation = $locationRepository->findByLastLocation(3);
        return $this->render('home/index.html.twig', [
            'lastLocation' => $lastLocation,
            'pictures' => $pictures,
            'weather' => $weatherData

        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\LocationRepository;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SoloLocationController extends AbstractController
{
    #[Route('/soloLocation/{id}', name: 'soloLocation_app')]
    public function index(string $id,
                          LocationRepository $locationRepository,
                          PictureRepository  $pictureRepository,
                            CommentRepository $commentRepository
    ): Response

    {

        $location = $locationRepository->findOneBy(['id' => $id]);
        $pictures = $pictureRepository->findBy(['location' => $id]);
        $comment = $commentRepository->findBy(['location' => $id]);



        return $this->render('location/soloLocation.html.twig',[
            'location' => $location,
            'pictures' => $pictures,
            'comments' => $comment,


        ]);

    }




}

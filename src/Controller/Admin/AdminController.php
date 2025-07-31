<?php

declare(strict_types=1);

namespace App\Controller\Admin;


use App\Entity\Location;
use App\Entity\User;
use App\Form\AddLocationForm;
use App\Repository\LocationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

class AdminController extends AbstractController
{
    #[Route('/admin',  name: 'app_admin')]
    public function indexAllLocation(PaginatorInterface $paginator, Request $request, locationRepository $locationRepository): Response
    {
//               $location = $locationRepository->findAll();


        $location = $paginator->paginate(
            $locationRepository->findAll(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */

        );


        dump($this->getUser()->getRoles());
        return $this->render('admin/admin_index.html.twig', [
            'locations' => $location,
        ]);
    }


    #[Route('/formLocation', name: 'app_formLocation' , methods: ['POST', 'GET'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $newLocation = new Location();

        $form = $this->createForm(AddLocationForm::class, $newLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newLocation->setCreatedAt(new DateTime());

            $user = $this->getUser();
            $newLocation->setUser($user);

            $em->persist($newLocation);
            $em->flush();

                return $this->redirectToRoute('app_admin');
    }
        return $this->render('admin/admin_addlocation.html.twig', [
            'locationForm' => $form->createView(),
        ]);
    }



    private function setCreatedAt(\DateTimeImmutable $param)
    {
    }


}



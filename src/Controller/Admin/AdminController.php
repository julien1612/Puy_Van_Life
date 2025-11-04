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

        //récupération et pagination
        $location = $paginator->paginate(
            $locationRepository->findAll(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */

        );

        return $this->render('admin/admin_index.html.twig', [
            'locations' => $location,
        ]);
    }

    #[Route('/admin/user',  name: 'app_adminUser')]
    public function indexUser(PaginatorInterface $paginator, Request $request, UserRepository $userRepository): Response
    {
        //récupération et pagination
        $user = $paginator->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        return $this->render('admin/admin_user.html.twig', [
            'users' => $user,
        ]);
    }



    #[Route('/formLocation', name: 'app_formLocation' , methods: ['POST', 'GET'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        //On crée un nouvel objet Location vide
        $newLocation = new Location();

        //création du form
        $form = $this->createForm(AddLocationForm::class, $newLocation);
        $form->handleRequest($request);

        //Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $newLocation->setCreatedAt(new DateTime());

            //Récupère l'utilisateur connecté et l'associe à la location
            $user = $this->getUser();
            $newLocation->setUser($user);

            //prépare et enregistre
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

    #[Route('/admin/location{id}', name: 'app_location_show')]
    public function show(string $id, locationRepository $locationRepository): Response
    {
        $locationSolo = $locationRepository->find($id);
        $picture = $locationSolo->getPicture();
        $comments = $locationSolo->getComments();


        return $this->render('admin/admin_showLocation.html.twig', [
            'locationSolo' => $locationSolo,
            'pictures' => $picture,
            'comments' => $comments,
        ]);
    }

    #[Route('/formLocation/{id}', name: 'app_location_edit' , methods: ['POST', 'GET'])]
    public function edit(int $id, LocationRepository $locationRepository,Request $request, EntityManagerInterface $em): Response
    {
        $editLocation = $locationRepository ->findOneBy(['id' => $id]);

        $form = $this->createForm(AddLocationForm::class, $editLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editLocation->setCreatedAt(new DateTime());

            $user = $this->getUser();
            $editLocation->setUser($user);

            $em->persist($editLocation);
            $em->flush();

            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/admin_editLocation.html.twig', [
            'editLocationForm' => $form->createView(),
        ]);
    }

    #[Route('/deleteFormLocation/{id}', name: 'app_deleteFormLocation' , methods: ['POST', 'GET'])]
    public function delete(int $id, Request $request, LocationRepository $locationRepository, EntityManagerInterface $em): Response
    {

        $deleteLocation = $locationRepository->findOneBy(['id' => $id]);

        $em->remove($deleteLocation);
        $em->flush();

        return $this->redirectToRoute('app_admin');

    }


    #[Route('/menu', name: 'app_menu' )]
    public function menu(): Response
    {

        return $this->render('admin/admin_menu.html.twig');
    }


}



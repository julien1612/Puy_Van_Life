<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Form\CommentForm;
use App\Repository\CommentRepository;
use App\Repository\LocationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/{id}', name: 'app_comment')]
    public function comment(int                    $id,
                            EntityManagerInterface $entityManager,
                            Request                $request,
                            LocationRepository     $locationRepository,

    ): Response
    {

        $location = $locationRepository->findOneBy(['id' => $id]);
        $newComment = new Comment();
        $form = $this->createForm(CommentForm::class, $newComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();
            $newComment->setUser($user);
            $newComment->setLocation($location);
            $newComment->setCommentDate(new \DateTime());

            $entityManager->persist($newComment);
            $entityManager->flush();

            return $this->redirectToRoute('soloLocation_app', ['id' => $location->getId()]);

        }

        return $this->render('comment/comment.html.twig', [
            'commentForm' => $form->createView(),
            'newComment' => $newComment,
            'location' => $location,
        ]);

    }
}

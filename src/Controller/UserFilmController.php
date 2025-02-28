<?php

namespace App\Controller;

use App\Entity\UserFilm;
use App\Form\UserFilmType;
use App\Repository\UserFilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/favorite')]
final class UserFilmController extends AbstractController
{
    #[Route(name: 'app_user_film_index', methods: ['GET'])]
    public function index(UserFilmRepository $userFilmRepository): Response
    {
        return $this->render('user_film/index.html.twig', [
            'user_films' => $userFilmRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_film_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userFilm = new UserFilm();
        $form = $this->createForm(UserFilmType::class, $userFilm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userFilm);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_film/new.html.twig', [
            'user_film' => $userFilm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_film_show', methods: ['GET'])]
    public function show(UserFilm $userFilm): Response
    {
        return $this->render('user_film/show.html.twig', [
            'user_film' => $userFilm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_film_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserFilm $userFilm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserFilmType::class, $userFilm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_film/edit.html.twig', [
            'user_film' => $userFilm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_film_delete', methods: ['POST'])]
    public function delete(Request $request, UserFilm $userFilm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userFilm->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($userFilm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_film_index', [], Response::HTTP_SEE_OTHER);
    }
}

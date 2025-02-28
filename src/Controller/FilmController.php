<?php
namespace App\Controller;
use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
final class FilmController extends AbstractController
{
    #[IsGranted(attribute: 'IS_AUTHENTICATED_FULLY')]
    #[Route(path:'/',name: 'app_accueil')]
    #[Route(path:'/film',name: 'app_film_index')]
    public function index(FilmRepository $filmRepository): Response
    {
        return $this->render('film/index.html.twig', [
            'films' => $filmRepository->findAll(),
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('film/new', name: 'app_film_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($film);
            $entityManager->flush();
            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('film/new.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }
    #[Route('film/{id}', name: 'app_film_show', methods: ['GET'])]
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('film/{id}/edit', name: 'app_film_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('film/{id}', name: 'app_film_delete', methods: ['POST'])]
    public function delete(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($film);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
    }
}
<?php

namespace App\Controller;

use App\Entity\Attraction;
use App\Repository\AttractionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttractionController extends AbstractController
{
    #[Route('/attraction', name: 'app_attraction')]
    public function index(AttractionRepository $attractionRepository): Response
    {
        return $this->render('attraction/index.html.twig', [
            'attractions' => $attractionRepository->findAll(),
        ]);
    }

    #[Route('/attraction/new', name: 'app_attraction_new', methods: ["GET"])]
    public function new(): Response
    {
        return $this->render('attraction/new.html.twig');
    }

    #[Route('/attraction/new', name: 'app_attraction_new_post', methods: ["POST"])]
    public function newPost(Request $request, AttractionRepository $attractionRepository): Response
    {
        $name = $request->get("name");
        $shortDescription = $request->get("short_description");
        $fullDescription = $request->get("full_description");
        $score = $request->get("score");


        $attraction = new Attraction();
        $attraction->setName($name);
        $attraction->setShortDescription($shortDescription);
        $attraction->setFullDescription($fullDescription);
        $attraction->setScore($score);
        $attraction->setCreateAt(new \DateTimeImmutable());

        $attractionRepository->save($attraction, true);

        return $this->redirectToRoute("app_attraction_view", ['id' => $attraction->getId()]);
    }

    #[Route('/attraction/{id}/edit', name: 'app_attraction_edit', methods: ["GET"])]
    public function edit(Attraction $attraction): Response
    {
        return $this->render('attraction/edit.html.twig', [
            'attraction' => $attraction
        ]);
    }

    #[Route('/attraction/{id}/edit', name: 'app_attraction_edit_post', methods: ["POST"])]
    public function editPost(Attraction $attraction, Request $request, AttractionRepository $attractionRepository): Response
    {
        $name = $request->get("name");
        $shortDescription = $request->get("short_description");
        $fullDescription = $request->get("full_description");
        $score = $request->get("score");

        $attraction->setName($name);
        $attraction->setShortDescription($shortDescription);
        $attraction->setFullDescription($fullDescription);
        $attraction->setScore($score);
        $attraction->setUpdatedAt(new \DateTimeImmutable());

        $attractionRepository->save($attraction, true);

        return $this->redirectToRoute("app_attraction_view", ['id' => $attraction->getId()]);
    }

    #[Route('/attraction/{id}/delete', name: 'app_attraction_delette')]
    public function delette(Attraction $attraction, AttractionRepository $attractionRepository): Response
    {
        $attractionRepository->remove($attraction, true);

        return $this->redirectToRoute("app_attraction");
    }

    #[Route('/attraction/{id}', name: 'app_attraction_view')]
    public function view(Attraction $attraction): Response
    {
        return $this->render('attraction/view.html.twig', [
            'attraction' => $attraction,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Park;
use App\Repository\ParkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/park', name: 'park_')]
class ParkController extends AbstractController
{
    public function __construct(private ParkRepository $parkRepository)
    {
    }

    #[Route('', name: 'list')]
    public function list(): Response
    {
        $parks = $this->parkRepository->findAll();

        return $this->render("park/list.html.twig", [
            'parks' => $parks
        ]);
    }

    #[Route('/{id}', name: 'view', requirements: ["id" => "\d+"])]
    public function view(Park $park): Response
    {
        return $this->render("park/view.html.twig", [
            'park' => $park,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function form(): Response
    {
        return new Response("Création d'un parc");
    }
}

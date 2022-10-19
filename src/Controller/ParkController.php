<?php

namespace App\Controller;

use App\Repository\ParkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/park', name: 'park_')]
class ParkController extends AbstractController
{
    private ParkRepository $parkRepository;

    public function __construct(ParkRepository $parkRepository)
    {
        $this->parkRepository = $parkRepository;
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
    public function view($id): Response
    {
        $park = $this->parkRepository->find($id);

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

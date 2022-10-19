<?php

namespace App\Controller;

use App\Repository\CoasterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/coaster', name: 'coaster_')]
class CoasterController extends AbstractController
{
    private CoasterRepository $coasterRepository;

    public function __construct(CoasterRepository $coasterRepository)
    {
        $this->coasterRepository = $coasterRepository;
    }

    #[Route('', name: 'list')]
    public function list(): Response
    {
        $coasters = $this->coasterRepository->findAll();

        return $this->render("coaster/list.html.twig", [
            "coasters" => $coasters,
        ]);
    }

    #[Route('/{id}', name: 'view', requirements: ["id" => "\d+"])]
    public function view($id): Response
    {
        $coaster = $this->coasterRepository->find($id);

        return $this->render("coaster/view.html.twig", [
            "coaster" => $coaster,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function form(): Response
    {
        return new Response("Création d'une attraction");
    }
}

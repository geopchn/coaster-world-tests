<?php

namespace App\Controller;

use App\Repository\CoasterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/coaster', name: 'coaster_')]
class CoasterController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(CoasterRepository $coasterRepository): Response
    {
        $coasters = $coasterRepository->findAll();

        return $this->render("coaster/list.html.twig", [
            "coasters" => $coasters,
        ]);
    }

    #[Route('/{id}', name: 'view', requirements: ["id" => "\d+"])]
    public function view($id): Response
    {
        return new Response(sprintf("Page de l'attraction %s", $id));
    }

    #[Route('/create', name: 'create')]
    public function form(): Response
    {
        return new Response("Création d'une attraction");
    }
}

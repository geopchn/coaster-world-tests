<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/park', name: 'park_')]
class ParkController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        return new Response("Liste des parcs");
    }

    #[Route('/{id}', name: 'view', requirements: ["id" => "\d+"])]
    public function view($id): Response
    {
        return new Response(sprintf("Page du parc %s", $id));
    }

    #[Route('/create', name: 'create')]
    public function form(): Response
    {
        return new Response("Création d'un parc");
    }
}

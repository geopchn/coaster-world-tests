<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("", name: "main_")]
class MainController extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        // Créer la page d'accueil
        // Header avec liens vers les listes
        // Une landing zone visuelle
        // Footer avec lien vers la page contact
        // CSS => dans balise style
        // Lien = lien en dur (ex: /park)
        return $this->render("main/home.html.twig");
    }

    #[Route("/contact", name: "contact")]
    public function contact(): Response
    {
        return new Response("Page de contact");
    }
}

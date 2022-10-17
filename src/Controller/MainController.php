<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("", name: "main_")]
class MainController extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return new Response("Page d'accueil");
    }

    #[Route("/contact", name: "contact")]
    public function contact(): Response
    {
        return new Response("Page de contact");
    }
}

<?php

namespace App\Controller;

use App\Entity\Park;
use App\Form\ParkType;
use App\Repository\ParkRepository;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/park', name: 'park_')]
class ParkController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private ParkRepository $parkRepository)
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
        $statistics = [
            'manufacturerCounter' => $this->parkRepository->countManufacturers($park),
        ];

        return $this->render("park/view.html.twig", [
            'park' => $park,
            'statistics' => $statistics,
        ]);
    }

    #[Route('/create', name: 'create')]
    #[Route('/{id}/edit', name: 'edit')]
    #[IsGranted("RESOURCE_WRITE", "park")]
    public function form(Request $request, FileService $fileService, ?Park $park = null): Response
    {
        $isNew = false;
        if(!$park){
            $park = new Park();
            $isNew = true;
        }
        $form = $this->createForm(ParkType::class, $park);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($imageFile = $park->getImageFile()){
                $name = $fileService->upload($imageFile, "park");
                if($oldImage = $park->getImage()){
                    $fileService->remove($oldImage);
                }
                $park->setImage($name);
            }

            $this->em->persist($park);
            $this->em->flush();

            $message = sprintf("Le parc a bien été %s", $isNew ? "créé" : "modifé");
            $this->addFlash("success", $message);
            return $this->redirectToRoute('park_view', [
                'id' => $park->getId(),
            ]);
        }

        return $this->render("park/form.html.twig", [
            "form" => $form->createView(),
            "isNew" => $isNew,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Form\CoasterType;
use App\Repository\CoasterRepository;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
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
    public function view(int $id): Response
    {
        $coaster = $this->coasterRepository->find($id);

        return $this->render("coaster/view.html.twig", [
            "coaster" => $coaster,
        ]);
    }

    #[Route('/create', name: 'create')]
    #[Route('/{id}/edit', name: 'edit')]
    public function form(Request $request, EntityManagerInterface $em, FileSystem $fs, FileService $fileService, ?Coaster $coaster = null): Response
    {
        $isNew = false;
        if(!$coaster){
            $coaster = new Coaster();
            $isNew = true;
        }
        $form = $this->createForm(CoasterType::class, $coaster);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($imageFile = $coaster->getImageFile()){
                $name = sprintf("%s.%s", uniqid("coaster-"), $imageFile->guessExtension());
                $imageFile->move("data", $name);
                if($oldImage = $coaster->getImage()){
                    $fs->remove("." . $oldImage);
                }
                $coaster->setImage("/data/" . $name);
            }

            $em->persist($coaster);
            $em->flush();

            $message = sprintf("L'attraction a bien été %s", $isNew ? "créé" : "modifé");
            $this->addFlash("success", $message);
            return $this->redirectToRoute('coaster_view', [
                'id' => $coaster->getId(),
            ]);
        }

        return $this->render("coaster/form.html.twig", [
            "form" => $form->createView(),
            "isNew" => $isNew,
        ]);
    }
}

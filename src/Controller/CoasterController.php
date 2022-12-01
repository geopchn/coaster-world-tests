<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Entity\UserExperience;
use App\Form\CoasterType;
use App\Repository\CoasterRepository;
use App\Repository\UserExperienceRepository;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/coaster', name: 'coaster_')]
class CoasterController extends AbstractController
{
    private CoasterRepository $coasterRepository;
    private EntityManagerInterface $em;

    public function __construct(CoasterRepository $coasterRepository, EntityManagerInterface $em)
    {
        $this->coasterRepository = $coasterRepository;
        $this->em = $em;
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
        $similarCoasters = $this->coasterRepository->findSimilar($coaster);

        // Ajouter deux boutons pour mettre en "à faire" ou en "fait" l'attraction
        // - Créer une nouvelle entité UserExperience et remplir ses informations
        // - Sauvegarder l'entité

        return $this->render("coaster/view.html.twig", [
            'coaster' => $coaster,
            'similarCoasters' => $similarCoasters,
        ]);
    }

    #[Route('/create', name: 'create')]
    #[Route('/{id}/edit', name: 'edit')]
    #[IsGranted("RESOURCE_WRITE", "coaster")]
    public function form(Request $request, FileService $fileService, ?Coaster $coaster = null): Response
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
                $name = $fileService->upload($imageFile, "coaster");
                if($oldImage = $coaster->getImage()){
                    $fileService->remove($oldImage);
                }
                $coaster->setImage($name);
            }

            $this->em->persist($coaster);
            $this->em->flush();

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

    #[Route('/{id}/delete', name: 'delete')]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Coaster $coaster): Response
    {
        $this->em->remove($coaster);
        $this->em->flush();
        $this->addFlash("success", "Le coaster a bien été supprimé");
        return $this->redirectToRoute("coaster_list");
    }

    #[Route('/{id}/experience', name: 'experience')]
    #[IsGranted('ROLE_USER')]
    public function experience(Request $request, UserExperienceRepository $userExperienceRepository, Coaster $coaster): Response
    {
        $user = $this->getUser();
        $isDone = (bool) $request->query->get('is_done');
        $experience = $userExperienceRepository->findOneBy([
           'coaster' => $coaster,
           'user' => $user,
        ]);

        if(!$experience){
            $experience = new UserExperience();
            $experience->setCoaster($coaster);
            $experience->setUser($user);
            $this->em->persist($experience);
        }

        if($isDone === $experience->isDone()){
            $this->em->remove($experience);
        } else {
            $experience->setIsDone($isDone);
        }

        $this->em->flush();

        return $this->redirectToRoute('coaster_view', [
           'id' => $coaster->getId(),
        ]);
    }
}

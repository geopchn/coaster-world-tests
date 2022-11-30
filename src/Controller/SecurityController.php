<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('', name: 'security_')]
class SecurityController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        MailerService $mailerService,
        UserPasswordHasherInterface $hasher
    ): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('main_home');
        }

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hashed = $hasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashed);

            $em->persist($user);
            $em->flush();

            $success = $mailerService->sendRegistrationConfirmation($user);
            if (!$success) {
                $this->addFlash('warning', 'Nous n\'avons pas pu vous envoyer le mail de confirmation');
            }
            $this->addFlash('success', 'Votre compte a bien été créé');
            return $this->redirectToRoute('main_home');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('main_home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername,
        ]);
    }

    #[Route('/logout', 'logout')]
    public function logout(): void
    {
    }
}

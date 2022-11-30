<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    private MailerInterface $mailer;
    private array $config;

    public function __construct(MailerInterface $mailer, ParameterBagInterface $parameterBag)
    {
        $this->mailer = $mailer;
        $this->config = $parameterBag->get('mailer');
    }

    public function sendRegistrationConfirmation(User $user): bool
    {
        return $this->send($user->getEmail(), 'Confirmation d\'inscription', 'register-confirmation', [
            'accountEmail' => $user->getEmail(),
            'username' => $user->getUsername(),
        ]);
    }

    private function send(string $to, string $subject, string $template, array $context = []): bool
    {
        $mail = new TemplatedEmail();
        $mail->from($this->config['senderAddress']);
        $mail->to($to);
        $mail->subject($subject);

        $templatePath = sprintf('%s%s.html.twig', $this->config['templateFolder'], $template);
        $mail->htmlTemplate($templatePath);
        $mail->context($context);

        try {
            $this->mailer->send($mail);
            return true;
        } catch (TransportExceptionInterface $exception) {
            return false;
        }
    }
}

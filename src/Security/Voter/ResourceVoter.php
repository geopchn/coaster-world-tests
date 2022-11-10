<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ResourceVoter extends Voter
{
    const ATTRIBUTE_ACTION = 'RESOURCE_WRITE';
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === self::ATTRIBUTE_ACTION;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if ($subject) {
            return $this->security->isGranted('ROLE_MODERATOR');
        } else {
            return $this->security->isGranted('ROLE_CONTRIBUTOR');
        }
    }
}

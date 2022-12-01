<?php

namespace App\Util\Twig;

use App\Entity\Coaster;
use App\Repository\UserExperienceRepository;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\RuntimeExtensionInterface;

class ExperienceButtonLabelRuntime implements RuntimeExtensionInterface
{
    const BUTTON_TYPE = [
        'todo' => 0,
        'done' => 1,
    ];

    private Security $security;
    private UserExperienceRepository $userExperienceRepository;

    public function __construct(Security $security, UserExperienceRepository $userExperienceRepository)
    {
        $this->security = $security;
        $this->userExperienceRepository = $userExperienceRepository;
    }

    public function buildLabel(int $buttonType, Coaster $coaster): string
    {
        $user = $this->security->getUser();
        $experience = $this->userExperienceRepository->findOneBy([
            'coaster' => $coaster,
            'user' => $user,
        ]);

        if ($buttonType === self::BUTTON_TYPE['todo']) {
            if(!$experience){
                return 'Je veux faire cette attraction';
            }

            if($experience->isDone() === true){
                return 'Je n\'ai pas encore fait cette attraction';
            }
        }else if(!$experience || $experience->isDone() === false){
            return 'J\'ai fait cette attraction';
        }

        return 'Retirer de ma liste';
    }
}

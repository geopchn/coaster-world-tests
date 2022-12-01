<?php

namespace App\Util\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('country_flag_url', [CountryFlagRuntime::class, 'buildCountryFlagUrl']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('experience_button_label', [ExperienceButtonLabelRuntime::class, 'buildLabel'])
        ];
    }
}

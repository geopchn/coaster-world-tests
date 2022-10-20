<?php

namespace App\Util\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter("country_flag_url", [CountryFlagRuntime::class, "buildCountryFlagUrl"]),
        ];
    }
}

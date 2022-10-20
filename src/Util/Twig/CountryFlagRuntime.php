<?php

namespace App\Util\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\RuntimeExtensionInterface;

class CountryFlagRuntime implements RuntimeExtensionInterface
{
    private array $config;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->config = $parameterBag->get('address');
    }

    public function buildCountryFlagUrl(string $countryCode): string
    {
        return $this->config["countryFlagBaseUrl"] . $countryCode;
    }
}

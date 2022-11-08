<?php

namespace App\Controller;

use App\Entity\Address;
use App\Service\WeatherService;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ajax', name: 'ajax_')]
class AjaxController extends AbstractController
{
    #[Route('/weather/{address_id}', name: 'weather', methods: ['GET'])]
    #[Entity('address', options: ['id' => 'address_id'])]
    public function weather(Address $address, WeatherService $weatherService): Response
    {
        try {
            $data = $weatherService->getForecastByAddress($address);
        } catch (Exception $e) {
            return $this->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'status' => true,
            'forecasts' => $data,
        ]);
    }
}

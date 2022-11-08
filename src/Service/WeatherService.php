<?php

namespace App\Service;

use App\Entity\Address;
use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// TODO - Improve timezone management
class WeatherService
{
    private HttpClientInterface $http;
    private array $config;

    public function __construct(HttpClientInterface $http, ParameterBagInterface $parameterBag)
    {
        $this->http = $http;
        $this->config = $parameterBag->get('weather');
    }

    public function getForecastByAddress(Address $address): array
    {
        $coordinates = $this->geocodeAddress($address);
        return $this->getForecastByCoordinates($coordinates);
    }

    private function geocodeAddress(Address $address): array
    {
        $queryString = sprintf('%s,%s', $address->getCity(), $address->getCountry());
        $data = $this->call($this->config['endpoints']['geocoding'], [
            'query' => [
                'q' => $queryString,
            ]
        ]);

        $location = reset($data);

        return [
            'lat' => $location['lat'],
            'lng' => $location['lon'],
        ];
    }

    private function getForecastByCoordinates(array $coordinates): array
    {
        $data = $this->call($this->config['endpoints']['forecast'], [
            'query' => [
                'lat' => $coordinates['lat'],
                'lon' => $coordinates['lng'],
                'lang' => 'fr',
                'units' => 'metric',
            ]
        ]);

        return $this->formatForecasts($data['list']);
    }

    private function call(string $endpoint, array $options = []): array
    {
        $url = sprintf('%s%s', $this->config['url'], $endpoint);
        $options['query']['appid'] = $this->config['key'];

        $response = $this->http->request('GET', $url, $options);
        return $response->toArray();
    }

    private function formatForecasts(array $rawForecasts): array
    {
        $forecasts = [];
        $previousDate = new DateTime('yesterday');

        foreach ($rawForecasts as $forecast) {
            $date = new DateTime();
            $date->setTimestamp($forecast['dt']);

            if ($previousDate->format('Ymd') !== $date->format('Ymd')) {
                $weather = reset($forecast['weather']);

                $forecasts[] = [
                    'id' => strtolower($weather['main']),
                    'date' => $date,
                    'label' => ucfirst($weather['description']),
                    'temperature' => $forecast['main']['temp'],
                ];
            }

            $previousDate = $date;
        }

        return $forecasts;
    }
}

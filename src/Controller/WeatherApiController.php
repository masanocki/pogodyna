<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use App\Entity\Forecast;
use App\Entity\City;
use App\Service\WeatherUtil;
use Symfony\Component\HttpFoundation\Response;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        #[MapQueryParameter('city')] string $city,
        #[MapQueryParameter('country')] string $country,
        WeatherUtil $util,
        #[MapQueryParameter('format')] string $format,
        #[MapQueryParameter('twig')] bool $twig = false
    ): Response
    {
        $forecasts = $util->getWeatherForCountryAndCity($country, $city);

        if ($format === 'csv') {
            if ($twig) {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'forecasts' => $forecasts,
                ]);
            }
            $csvData = "city,country,date,temperature,fahrenheit\n";
            foreach ($forecasts as $forecast) {
                $rowData = [
                    $city,
                    $country,
                    $forecast->getDate()->format('Y-m-d'),
                    $forecast->getTemperature(),
                    $forecast->getFahrenheit()
                ];
                $csvData .= implode(',', $rowData) . "\r\n";
            }

            $response = new Response($csvData);
            // $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        }
        if ($twig){
            return $this->render('weather_api/index.json.twig', [
                'city' => $city,
                'country' => $country,
                'forecasts' => $forecasts,
            ]);
        }
        return $this->json([
            'city' => $city,
            'country' => $country,
            'forecasts' => array_map(fn(Forecast $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'temperature' => $m->getTemperature(),
                'fahrenheit' => $m->getFahrenheit(),
            ], $forecasts)
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\City;
use App\Service\WeatherUtil;
use App\Repository\ForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{name}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function location(City $city, WeatherUtil $util): Response
    {
        $forecasts = $util->getWeatherForLocation($city);
        
        return $this->render('weather/location.html.twig', [
            'city' => $city,
            'forecasts' => $forecasts,
        ]);
    }
}

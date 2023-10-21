<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\ForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{name}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function location(City $city, ForecastRepository $repository): Response
    {
        $forecasts = $repository->findByLocation($city);
        
        return $this->render('weather/location.html.twig', [
            'city' => $city,
            'forecasts' => $forecasts,
        ]);
    }
}

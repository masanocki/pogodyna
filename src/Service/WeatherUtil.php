<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\City;
use App\Entity\Forecast;
use App\Repository\CityRepository;
use App\Repository\ForecastRepository;

class WeatherUtil
{

    public function __construct(
        private ForecastRepository $forecastRep,
        private CityRepository $cityRep
    ) {
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForLocation(City $city): array
    {
        return $this->forecastRep->findByLocation($city);
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->cityRep->findBy([
            'country' => $countryCode,
            'name' => $city
        ])[0];
        return $this->getWeatherForLocation($location);
    }
}

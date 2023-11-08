<?php

namespace App\Entity;

use App\Repository\ForecastRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForecastRepository::class)]
class Forecast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'forecasts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $temperature = null;

    #[ORM\Column(length: 255)]
    private ?string $humidity = null;

    #[ORM\Column(length: 255)]
    private ?string $weathercondition = null;

    #[ORM\Column(length: 255)]
    private ?string $windspeed = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(string $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getWeathercondition(): ?string
    {
        return $this->weathercondition;
    }

    public function setWeathercondition(string $weathercondition): static
    {
        $this->weathercondition = $weathercondition;

        return $this;
    }

    public function getWindspeed(): ?string
    {
        return $this->windspeed;
    }

    public function setWindspeed(string $windspeed): static
    {
        $this->windspeed = $windspeed;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getFahrenheit(): ?string
    {
        return $this->temperature * 9/5 + 32;
    }
}

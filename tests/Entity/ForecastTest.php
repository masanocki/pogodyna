<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Forecast;

class ForecastTest extends TestCase
{

    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['25.5', 77.9],
            ['-5.5', 22.1],
            ['10.5', 50.9],
            ['0.5', 32.9],
            ['37.5', 99.5],
            ['-15.5', 4.1],
            ['30.5', 86.9]
        ];
    }

    /**
    * @dataProvider dataGetFahrenheit
    */
    public function testGetFahrenheit($temperature, $expectedFahrenheit): void
    {
        $forecast = new Forecast();
        $forecast->setTemperature($temperature);
        $this->assertEquals($expectedFahrenheit, $forecast->getFahrenheit());


        // $forecast->setTemperature(0);
        // $this->assertEquals(32, $forecast->getFahrenheit());
        
        // $forecast->setTemperature(-100);
        // $this->assertEquals(-148, $forecast->getFahrenheit());

        // $forecast->setTemperature(100);
        // $this->assertEquals(212, $forecast->getFahrenheit());
    }
}

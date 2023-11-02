<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\CityRepository;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:location',
    description: 'Add a short description for your command',
)]
class WeatherLocationCommand extends Command
{
    public function __construct(
        private CityRepository $cityRep,
        private WeatherUtil $weatherUtil
    ){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $locationId = $input->getArgument('arg1');
        $city = $this->cityRep->find($locationId);

        $forecasts = $this->weatherUtil->getWeatherForLocation($city);
        $io->writeln(sprintf('City: %s', $city->getName()));
        foreach ($forecasts as $forecast) {
            $io->writeln(sprintf("\t%s: %s",
                $forecast->getDate()->format('Y-m-d'),
                $forecast->getTemperature()
            ));
        }

        return Command::SUCCESS;
    }

}

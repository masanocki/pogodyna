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
    name: 'weather:countrycity',
    description: 'Add a short description for your command',
)]
class WeatherCountrycityCommand extends Command
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
            ->addArgument('code', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('name', InputArgument::REQUIRED, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $code = $input->getArgument('code');
        $name = $input->getArgument('name');

        $forecasts = $this->weatherUtil->getWeatherForCountryAndCity($code, $name);
        $io->writeln(sprintf('Location: %s', $name));
        foreach ($forecasts as $forecast) {
            $io->writeln(sprintf("\t%s: %s",
                $forecast->getDate()->format('Y-m-d'),
                $forecast->getTemperature()
            ));
        }

        return Command::SUCCESS;
    }
}

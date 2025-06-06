<?php
// src/Command/MyFunctionsCommand.php
namespace App\Command;

use App\Service\HandrunFunctions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class HandrunCommand extends Command
{
    protected static $defaultName = 'app:handruncommand';
    private $handrunFunctions;

    public function __construct(HandrunFunctions $handrunFunctions)
    {
        parent::__construct();
        $this->handrunFunctions = $handrunFunctions;
    }

    protected function configure(): void
    {
        $this->setDescription('Uruchamia funkcje z serwisu MyFunctionsService');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Rozpoczęcie operacji ręcznych...</info>');
        $stopwatch = new Stopwatch();
        $stopwatch->start('handrun_execution');
//        $this->handrunFunctions->addProductColors($output);
        $this->handrunFunctions->addProducts($output, 18,true);
        $event = $stopwatch->stop('handrun_execution');
        $durationMs = $event->getDuration(); // czas w milisekundach
        $totalSeconds = (int) floor($durationMs / 1000);
        $hours   = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;
        $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        $memoryUsage = $event->getMemory();
        $output->writeln(sprintf(
            '<comment>Czas wykonania: %s, Zużycie pamięci: %.2f MB</comment>',
            $formattedTime,
            $memoryUsage / 1024 / 1024
        ));

        $output->writeln('<info>Zakończono.</info>');

        return Command::SUCCESS;
    }
}

<?php
// src/Command/MyFunctionsCommand.php
namespace App\Command;

use App\Service\HandrunFunctions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $this->handrunFunctions->addProductColors($output);
        $output->writeln('<info>Zakończono.</info>');

        return Command::SUCCESS;
    }
}

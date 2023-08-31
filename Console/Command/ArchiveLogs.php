<?php

namespace WebAtypique\LogArchiver\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WebAtypique\LogArchiver\Model\Archive;

class ArchiveLogs extends Command
{
    protected Archive $_archiverModel;

    public function __construct(
        Archive $archiverModel,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->_archiverModel = $archiverModel;
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('logs:archive');
        $this->setDescription('Archive logs in var/log');
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Start to archive logs');
        $this->_archiverModel->execute();
        $output->writeln('End to archive logs');
    }
}

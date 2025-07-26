<?php

namespace WebAtypique\LogArchiver\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WebAtypique\LogArchiver\Helper\Data;
use WebAtypique\LogArchiver\Model\Archive;

class ArchiveLogs extends Command
{
    protected Archive $_archiverModel;
    protected Data $_helper;

    public function __construct(
        Archive $archiverModel,
        Data $helper,
        ?string $name = null
    )
    {
        parent::__construct($name);
        $this->_archiverModel = $archiverModel;
        $this->_helper = $helper;
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
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if(!$this->_helper->isModuleEnable()){
            $output->writeln('Module is disabled');
            return Cli::RETURN_FAILURE;
        }

        $output->writeln('Start to archive logs');
        $this->_archiverModel->execute();
        $output->writeln('End to archive logs');
        return Cli::RETURN_SUCCESS;
    }
}

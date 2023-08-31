<?php


namespace WebAtypique\LogArchiver\Cron;


use WebAtypique\LogArchiver\Model\Archive;

class ArchiveLogsCronjob
{
    protected Archive $_archiverModel;

    public function __construct(
        Archive $archiverModel
    )
    {
        $this->_archiverModel = $archiverModel;
    }

    /**
     * Cronjob Description
     */
    public function execute(): void
    {
        $this->_archiverModel->execute();
    }
}

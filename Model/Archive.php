<?php

namespace WebAtypique\LogArchiver\Model;

use Magento\Framework\Exception\FileSystemException;

class Archive
{
    const ARCHIVE_PATH = '/archives/';

    protected \Magento\Framework\Filesystem\DirectoryList $_dir;
    protected \Psr\Log\LoggerInterface $_logger;

    public function __construct(
        \Magento\Framework\Filesystem\DirectoryList $dir,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_dir = $dir;
        $this->_logger = $logger;
    }

    public function execute(): void
    {
        try {
            $logDir = $this->_dir->getPath('log');

            $logsFiles = $this->_getLogFiles($logDir);

            if(count($logsFiles) > 0){

                // CREER LE REPERTOIRE ARCHIVE SI NECESSAIRE
                $this->_createFolderIfNeeded($logDir . self::ARCHIVE_PATH);

                foreach ($logsFiles as $fileName){
                    $filePath = $logDir . '/' . $fileName;

                    // NE RIEN ARCHIVER SI LE FICHIER DE LOG N'EXISTE PAS
                    if(!file_exists($filePath)){
                        continue;
                    }

                    // ARCHIVER
                    $folder = $logDir . self::ARCHIVE_PATH . date('Ymd') . '/';
                    $tmpFilePath = $folder . $fileName;

                    $this->_createFolderIfNeeded($folder);

                    copy($filePath, $tmpFilePath);

                    $archive = $this->_gzCompressFile($tmpFilePath);

                    if($archive){
                        $this->_remvoveFiles([$filePath, $tmpFilePath]);
                    } else {
                        $this->_logger->error('WebAtypique_LogArchiver: Error when generating compress files.');
                    }
                }
            }
        } catch (FileSystemException $e) {
            $this->_logger->error('WebAtypique_LogArchiver: Can\'t find log folder.');
        }
    }

    private function _gzCompressFile($source, $level = 9): ?string
    {
        $dest = $source . '_' . date('Ymd_Hi') . '.gz';
        $mode = 'wb' . $level;
        $error = false;
        if ($fp_out = gzopen($dest, $mode)) {
            if ($fp_in = fopen($source,'rb')) {
                while (!feof($fp_in))
                    gzwrite($fp_out, fread($fp_in, 1024 * 512));
                fclose($fp_in);
            } else {
                $error = true;
            }
            gzclose($fp_out);
        } else {
            $error = true;
        }
        if ($error)
            return false;
        else
            return $dest;
    }

    private function _remvoveFiles(array $files): void
    {
        foreach ($files as $file) {
            unlink($file);
        }
    }

    private function _createFolderIfNeeded(string $folder): void
    {
        if(!is_dir($folder)){
            mkdir($folder, 0775);
        }
    }

    private function _getLogFiles(string $logDir): array
    {
        $result = array();
        $scandir = scandir($logDir);
        foreach ($scandir as $scan){
            if(is_file($logDir . '/' . $scan)){
                $result[] = $scan;
            }
        }
        return $result;
    }

}

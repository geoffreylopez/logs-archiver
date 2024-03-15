# Web Atypique - Logs Archiver Magento 2

## Online Documentation
https://web-atypique.fr/magento-2-log-archiver

## Pre-requisites
- Magento 2.4.6 or higher
- Php 8.0 or higher

## How to install WebAtypique_LogsArchiver

### Via Composer
```
composer require web-atypique/log-archiver
bin/magento setup:upgrade
bin/magento cache:flush
```

## How it's work

### Where are the archived logs?

The archived logs are stored in the `var/log/archive` directory in .gz files.

![web-atypique-archive-logs-screen](https://github.com/geoffreylopez/logs-archiver/assets/22189480/a3396274-2e66-42b3-941b-3dc1d5e9b077)


### Is it automatic?

Yes, the logs are automatically archived every day at 06am.
Here is the cronjob configuration:
```
<job name="webatypique_logarchiver_archive_logs_cronjob" instance="WebAtypique\LogArchiver\Cron\ArchiveLogsCronjob"
             method="execute">
            <schedule>0 6 * * *</schedule>
</job>
```

You can also launch the archiving manually with the following command:
```
bin/magento logs:archive
```

### Is it free?

Yes, it's fully free and open-source.

## Need More Features?
Please contact us to https://web-atypique.fr/contact

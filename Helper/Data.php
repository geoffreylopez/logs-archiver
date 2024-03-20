<?php

namespace WebAtypique\LogArchiver\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_CONFIG_PATH = 'system/log_archiver/';

    public function getConfigValue(string $field): mixed
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE
        );
    }

    public function isModuleEnable(): bool
    {
        return (bool) $this->getConfigValue(self::XML_CONFIG_PATH .'enabled');
    }

}

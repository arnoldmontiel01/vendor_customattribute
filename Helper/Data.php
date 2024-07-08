<?php
namespace Vendor\CustomAttribute\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_CUSTOMATTRIBUTE_ENABLE = 'customattribute/settings/enable';

    public function isCustomAttributeEnabled($storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CUSTOMATTRIBUTE_ENABLE, ScopeInterface::SCOPE_STORE, $storeId);
    }
}

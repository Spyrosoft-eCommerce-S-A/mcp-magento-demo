<?php
namespace Spyrosoft\MCPChatBotv6\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_ENABLED = 'mcpchatbotv6/general/enabled';
    const XML_PATH_BEARER_TOKEN = 'mcpchatbotv6/general/bearer_token';

    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getBearerToken($storeId = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_BEARER_TOKEN, ScopeInterface::SCOPE_STORE, $storeId);
    }
}

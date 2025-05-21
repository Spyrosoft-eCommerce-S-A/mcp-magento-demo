<?php
namespace Spyrosoft\MCPChatBotv2\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_MODULE_ENABLED = 'mcpchatbot/general/enable';
    const XML_PATH_RETURN_POLICY = 'mcpchatbot/general/return_policy_text';
    const XML_PATH_BEARER_TOKEN_ENABLED = 'mcpchatbot/security/enable_bearer_token';
    const XML_PATH_BEARER_TOKEN = 'mcpchatbot/security/bearer_token';

    /**
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_MODULE_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getReturnPolicyText()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_RETURN_POLICY,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isBearerTokenEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_BEARER_TOKEN_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getBearerToken()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_BEARER_TOKEN,
            ScopeInterface::SCOPE_STORE
        );
    }
}

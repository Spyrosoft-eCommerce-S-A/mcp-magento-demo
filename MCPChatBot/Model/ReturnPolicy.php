<?php
namespace Spyrosoft\MCPChatBot\Model;

use Spyrosoft\MCPChatBot\Api\ReturnPolicyInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ReturnPolicy implements ReturnPolicyInterface
{
    const XML_PATH_POLICY = 'spyrosoft_mcpchatbot/general/return_policy';
    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getReturnPolicy()
    {
        $policy = $this->scopeConfig->getValue(self::XML_PATH_POLICY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (!$policy) {
            $policy = 'You may return items within 30 days of delivery. Please contact support for RMA instructions.';
        }
        return ['policy_text' => $policy];
    }
}

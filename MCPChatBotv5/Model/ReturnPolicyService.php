<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Model;

use Spyrosoft\MCPChatBotv5\Api\ReturnPolicyServiceInterface;
use Spyrosoft\MCPChatBotv5\Api\Data\ReturnPolicyInterface;
use Spyrosoft\MCPChatBotv5\Api\Data\ReturnPolicyInterfaceFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ReturnPolicyService implements ReturnPolicyServiceInterface
{
    private const XML_PATH = 'mcpchatbot/general/return_policy';

    public function __construct(
        private ReturnPolicyInterfaceFactory $factory,
        private ScopeConfigInterface $scopeConfig
    ) {}

    public function getReturnPolicy(): ReturnPolicyInterface
    {
        $policy = $this->factory->create();
        $text = $this->scopeConfig->getValue(self::XML_PATH, ScopeInterface::SCOPE_STORE) ?: '';
        $policy->setPolicyText($text);
        return $policy;
    }
}

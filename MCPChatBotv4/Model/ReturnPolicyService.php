<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Model;

use Spyrosoft\MCPChatBotv4\Api\ReturnPolicyServiceInterface;
use Spyrosoft\MCPChatBotv4\Api\Data\ReturnPolicyInterface;
use Spyrosoft\MCPChatBotv4\Api\Data\ReturnPolicyInterfaceFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ReturnPolicyService implements ReturnPolicyServiceInterface
{
    private const XML_PATH_RETURN_POLICY = 'mcpchatbot/general/return_policy';

    public function __construct(
        private ReturnPolicyInterfaceFactory $returnPolicyFactory,
        private ScopeConfigInterface $scopeConfig
    ) {}

    public function getReturnPolicy(): ReturnPolicyInterface
    {
        $returnPolicy = $this->returnPolicyFactory->create();
        
        $policyText = $this->scopeConfig->getValue(
            self::XML_PATH_RETURN_POLICY,
            ScopeInterface::SCOPE_STORE
        ) ?? 'No return policy has been configured.';

        $returnPolicy->setPolicyText($policyText);
        
        return $returnPolicy;
    }
}

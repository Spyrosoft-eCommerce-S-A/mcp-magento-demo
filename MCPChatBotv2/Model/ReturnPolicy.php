<?php
namespace Spyrosoft\MCPChatBotv2\Model;

use Spyrosoft\MCPChatBotv2\Api\ReturnPolicyInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ReturnPolicy implements ReturnPolicyInterface
{
    const XML_PATH_POLICY_TEXT = 'mcpchatbot/general/return_policy_text'; // Example path, adjust as needed

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getReturnPolicy()
    {
        $policyText = $this->scopeConfig->getValue(
            self::XML_PATH_POLICY_TEXT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if (empty($policyText)) {
            $policyText = 'You may return items within 30 days of delivery. Please contact support for RMA instructions.'; // Default policy
        }

        return [
            [
                'policy_text' => $policyText
            ]
        ];
    }
}

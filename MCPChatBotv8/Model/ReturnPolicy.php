<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Model;

use Spyrosoft\MCPChatBot\Api\ReturnPolicyInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class ReturnPolicy
 */
class ReturnPolicy implements ReturnPolicyInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var AuthValidator
     */
    private $authValidator;

    /**
     * ReturnPolicy constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param AuthValidator $authValidator
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        AuthValidator $authValidator
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->authValidator = $authValidator;
    }

    /**
     * @inheritDoc
     */
    public function getReturnPolicy()
    {
        // Check if module is enabled
        if (!$this->isModuleEnabled()) {
            throw new LocalizedException(__('MCP ChatBot module is disabled.'));
        }

        // Validate authentication if required
        $this->authValidator->validate();

        $policyText = $this->scopeConfig->getValue(
            'spyrosoft_mcpchatbot/general/return_policy',
            ScopeInterface::SCOPE_STORE
        );

        if (empty($policyText)) {
            $policyText = 'You may return items within 30 days of delivery. Please contact support for RMA instructions.';
        }

        return [
            'policy_text' => $policyText
        ];
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    private function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'spyrosoft_mcpchatbot/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }
}

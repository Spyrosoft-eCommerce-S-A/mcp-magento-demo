<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Webapi\Rest\Request;

/**
 * Class AuthValidator
 */
class AuthValidator
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Request
     */
    private $request;

    /**
     * AuthValidator constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param Request $request
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Request $request
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
    }

    /**
     * Validate authentication
     *
     * @throws AuthenticationException
     */
    public function validate()
    {
        $requireToken = $this->scopeConfig->isSetFlag(
            'spyrosoft_mcpchatbot/general/require_token',
            ScopeInterface::SCOPE_STORE
        );

        if (!$requireToken) {
            return; // No authentication required
        }

        $configuredToken = $this->scopeConfig->getValue(
            'spyrosoft_mcpchatbot/general/bearer_token',
            ScopeInterface::SCOPE_STORE
        );

        if (empty($configuredToken)) {
            return; // No token configured, allow access
        }

        $authHeader = $this->request->getHeader('Authorization');
        if (!$authHeader) {
            throw new AuthenticationException(__('Authorization header is required.'));
        }

        $token = str_replace('Bearer ', '', $authHeader);
        if ($token !== $configuredToken) {
            throw new AuthenticationException(__('Invalid bearer token.'));
        }
    }
}

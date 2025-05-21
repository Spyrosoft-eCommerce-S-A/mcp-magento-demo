<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Plugin\Webapi\Controller;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Store\Model\ScopeInterface;
use Magento\Webapi\Controller\Rest as RestController;

class Rest
{
    private const XML_PATH_AUTH_TOKEN = 'mcpchatbot/general/auth_token';
    private const XML_PATH_ENABLED = 'mcpchatbot/general/enabled';

    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private RequestInterface $request
    ) {}

    public function beforeDispatch(RestController $subject): void
    {
        $path = trim($this->request->getPathInfo(), '/');
        
        // Only check MCP endpoints
        if (!str_starts_with($path, 'rest/V1/mcp/')) {
            return;
        }

        // Check if module is enabled
        if (!$this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE)) {
            throw new AuthorizationException(__('The MCP Chatbot module is disabled.'));
        }

        // Get configured auth token
        $configuredToken = $this->scopeConfig->getValue(self::XML_PATH_AUTH_TOKEN, ScopeInterface::SCOPE_STORE);
        
        // If no token is configured, allow anonymous access
        if (empty($configuredToken)) {
            return;
        }

        // Get bearer token from request
        $authHeader = $this->request->getHeader('Authorization');
        if (!$authHeader) {
            throw new AuthorizationException(__('Bearer token is required.'));
        }

        if (!preg_match('/Bearer\s+(.+)$/i', $authHeader, $matches)) {
            throw new AuthorizationException(__('Invalid authorization header format.'));
        }

        $providedToken = trim($matches[1]);
        if ($providedToken !== $configuredToken) {
            throw new AuthorizationException(__('Invalid bearer token.'));
        }
    }
}

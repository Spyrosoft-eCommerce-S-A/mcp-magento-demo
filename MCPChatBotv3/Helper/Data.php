<?php
/**
 * Data Helper for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Encryption\EncryptorInterface;

/**
 * Class Data
 */
class Data extends AbstractHelper
{
    /**
     * Config paths
     */
    const XML_PATH_ENABLED = 'mcp_chatbot/general/enabled';
    const XML_PATH_REQUIRE_AUTH = 'mcp_chatbot/general/require_auth';
    const XML_PATH_AUTH_TOKEN = 'mcp_chatbot/general/auth_token';
    const XML_PATH_RETURN_POLICY = 'mcp_chatbot/general/return_policy';

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        Context $context,
        EncryptorInterface $encryptor
    ) {
        $this->encryptor = $encryptor;
        parent::__construct($context);
    }

    /**
     * Check if module is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled(?int $storeId = null): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if authentication is required
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isAuthRequired(?int $storeId = null): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_REQUIRE_AUTH,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get authentication token
     *
     * @param int|null $storeId
     * @return string
     */
    public function getAuthToken(?int $storeId = null): string
    {
        $token = $this->scopeConfig->getValue(
            self::XML_PATH_AUTH_TOKEN,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        
        return $token ? $this->encryptor->decrypt($token) : '';
    }

    /**
     * Get return policy text
     *
     * @param int|null $storeId
     * @return string
     */
    public function getReturnPolicy(?int $storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_RETURN_POLICY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Validate bearer token from request
     *
     * @param string $authHeader
     * @return bool
     */
    public function validateAuthToken(string $authHeader): bool
    {
        if (!$this->isAuthRequired()) {
            return true;
        }
        
        if (empty($authHeader)) {
            return false;
        }
        
        // Extract the token
        $tokenParts = explode(' ', $authHeader);
        if (count($tokenParts) !== 2 || $tokenParts[0] !== 'Bearer') {
            return false;
        }
        
        $providedToken = $tokenParts[1];
        $configToken = $this->getAuthToken();
        
        return $providedToken === $configToken;
    }
}

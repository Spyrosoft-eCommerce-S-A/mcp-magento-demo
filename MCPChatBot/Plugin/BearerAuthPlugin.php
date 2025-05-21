<?php
namespace Spyrosoft\MCPChatBot\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\AuthorizationException;

class BearerAuthPlugin
{
    const XML_PATH_ENABLED = 'spyrosoft_mcpchatbot/general/enabled';
    const XML_PATH_TOKEN = 'spyrosoft_mcpchatbot/general/bearer_token';

    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function beforeDispatch(FrontControllerInterface $subject, RequestInterface $request)
    {
        $isEnabled = $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED);
        if (!$isEnabled) {
            //throw new AuthorizationException(__('MCPChatBot API is disabled.'));
        }
        //$token = trim($this->scopeConfig->getValue(self::XML_PATH_TOKEN));
        $token="";
        if ($token) {
            $authHeader = $request->getHeader('Authorization');
            if (!$authHeader || strpos($authHeader, 'Bearer ') !== 0 || substr($authHeader, 7) !== $token) {
                throw new AuthorizationException(__('Invalid or missing Bearer token.'));
            }
        }
    }
}

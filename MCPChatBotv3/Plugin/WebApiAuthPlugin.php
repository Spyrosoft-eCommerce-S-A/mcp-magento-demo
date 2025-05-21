<?php
/**
 * WebAPI Auth Plugin for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Plugin;

use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Webapi\Exception as WebapiException;
use Magento\Framework\Webapi\Rest\Response;
use Magento\Webapi\Controller\Rest;
use Spyrosoft\MCPChatBotv3\Helper\Data as Helper;

/**
 * WebAPI Auth Plugin
 */
class WebApiAuthPlugin
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string[]
     */
    private $mcpEndpoints = [
        '/V1/mcp/order-status/',
        '/V1/mcp/product-info/',
        '/V1/mcp/return-policy'
    ];

    /**
     * WebApiAuthPlugin constructor.
     *
     * @param Helper $helper
     * @param Request $request
     */
    public function __construct(
        Helper $helper,
        Request $request
    ) {
        $this->helper = $helper;
        $this->request = $request;
    }

    /**
     * Before dispatch check for MCP endpoint and validate token if needed
     *
     * @param Rest $subject
     * @param RequestInterface $request
     * @return void
     * @throws WebapiException
     */
    public function beforeDispatch(Rest $subject, RequestInterface $request)
    {
        // Only intercept MCP endpoints
        $uri = $this->request->getPathInfo();
        $isMcpRequest = false;
        
        foreach ($this->mcpEndpoints as $endpoint) {
            if (strpos($uri, $endpoint) === 0 || strpos($uri, $endpoint) !== false) {
                $isMcpRequest = true;
                break;
            }
        }
        
        if (!$isMcpRequest) {
            return; // Not an MCP endpoint, don't interfere
        }
        
        // Check if module is enabled
        if (!$this->helper->isEnabled()) {
            throw new WebapiException(
                __('MCP ChatBot module is disabled'),
                0,
                WebapiException::HTTP_FORBIDDEN
            );
        }
        
        // Check authentication if required
        if ($this->helper->isAuthRequired()) {
            $authHeader = $this->request->getHeader('Authorization');
            if (!$this->helper->validateAuthToken((string)$authHeader)) {
                throw new WebapiException(
                    __('Invalid or missing authentication token'),
                    0,
                    WebapiException::HTTP_UNAUTHORIZED
                );
            }
        }
    }
}

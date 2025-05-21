<?php
namespace Spyrosoft\MCPChatBotv6\Plugin;

use Magento\Framework\Webapi\Rest\Request as RestRequest;
use Magento\Framework\Webapi\Rest\Response as RestResponse;
use Spyrosoft\MCPChatBotv6\Helper\Data as Helper;

class RestAuthPlugin
{
    protected $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function beforeDispatch(RestRequest $subject)
    {
        if (!$this->helper->isEnabled()) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['error' => 'MCPChatBot API is disabled.']);
            exit;
        }
        $token = $this->helper->getBearerToken();
        if ($token) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            if (stripos($authHeader, 'Bearer ') === 0) {
                $provided = trim(substr($authHeader, 7));
                if ($provided !== $token) {
                    header('HTTP/1.1 401 Unauthorized');
                    echo json_encode(['error' => 'Invalid bearer token.']);
                    exit;
                }
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Bearer token required.']);
                exit;
            }
        }
    }
}

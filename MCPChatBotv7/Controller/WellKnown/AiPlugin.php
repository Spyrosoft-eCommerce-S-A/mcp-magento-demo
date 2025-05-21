<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Controller\WellKnown;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class AiPlugin implements HttpGetActionInterface
{
    private const RESPONSE_CODE_200 = 200;
    private const HEADER_CONTENT_TYPE = 'Content-Type';
    private const CONTENT_TYPE_JSON = 'application/json';
    private const URL = 'rest/V1/mcp/openapi.json';

    /**
     * @param JsonFactory $resultJsonFactory
     * @param RequestInterface $request
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private JsonFactory $resultJsonFactory,
        private RequestInterface $request,
        private StoreManagerInterface $storeManager
    ) {
    }

    /**
     *
     * @return Json
     */
    public function execute(): Json
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB);
        if (substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }

        $openApiUrl = $baseUrl . self::URL;

        $pluginData = [
            'schema_version' => 'v1',
            'name_for_human' => 'Magento Store MCP',
            'name_for_model' => 'MagentoStoreMCP',
            'description_for_human' => 'Magento Store MCP',
            'description_for_model' => 'Magento Store MCP',
            'auth' => [
                'type' => 'none'
            ],
            'api' => [
                'type' => 'openapi',
                'url' => $openApiUrl,
                'is_user_authenticated' => false
            ],
            'logo_url' => $baseUrl . 'logo.png',
            'contact_email' => 'support@example.com',
            'legal_info_url' => $baseUrl . 'legal'
        ];

        $result = $this->resultJsonFactory->create();
        $result->setData($pluginData);
        $result->setHttpResponseCode(self::RESPONSE_CODE_200);
        $result->setHeader(self::HEADER_CONTENT_TYPE, self::CONTENT_TYPE_JSON, true);
        $result->setHeader('Access-Control-Allow-Origin', '*', true);
        return $result;
    }
}

<?php
namespace Spyrosoft\MCPChatBotv2\Controller\WellKnown;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Response\Http;
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Store\Model\StoreManagerInterface;

class AiPluginJson implements HttpGetActionInterface
{
    protected $response;
    protected $moduleReader;
    protected $rawFactory;
    protected $storeManager;

    public function __construct(
        Http $response,
        Reader $moduleReader,
        RawFactory $rawFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->response = $response;
        $this->moduleReader = $moduleReader;
        $this->rawFactory = $rawFactory;
        $this->storeManager = $storeManager;
    }

    public function execute(): ResponseInterface
    {
        try {
            $moduleDir = $this->moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, 'Spyrosoft_MCPChatBotv2');
            $filePath = $moduleDir . '/../pub/ai-plugin.json'; // Path relative to etc directory

            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                $baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
                // Replace placeholder with actual store URL
                $content = str_replace('[STORE_URL_PLACEHOLDER]', rtrim($baseUrl, '/'), $content);

                $result = $this->rawFactory->create();
                $result->setHeader('Content-Type', 'application/json');
                $result->setContents($content);
                return $result;
            } else {
                $this->response->setStatusCode(Http::STATUS_CODE_404);
                return $this->response;
            }
        } catch (\Exception $e) {
            $this->response->setStatusCode(Http::STATUS_CODE_500);
            // Optionally log the exception $e->getMessage();
            return $this->response;
        }
    }
}

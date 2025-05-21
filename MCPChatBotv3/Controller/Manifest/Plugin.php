<?php
/**
 * AI Plugin Manifest Controller for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Controller\Manifest;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Store\Model\StoreManagerInterface;
use Spyrosoft\MCPChatBotv3\Helper\Data as Helper;

/**
 * Class Plugin
 */
class Plugin implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;
    
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    
    /**
     * @var Helper
     */
    private $helper;

    /**
     * Plugin constructor.
     *
     * @param JsonFactory $resultJsonFactory
     * @param StoreManagerInterface $storeManager
     * @param Helper $helper
     */
    public function __construct(
        JsonFactory $resultJsonFactory,
        StoreManagerInterface $storeManager,
        Helper $helper
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->storeManager = $storeManager;
        $this->helper = $helper;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $storeUrl = $this->storeManager->getStore()->getBaseUrl();
        $storeName = $this->storeManager->getStore()->getName();
        
        $manifest = [
            'schema_version' => 'v1',
            'name_for_human' => $storeName . ' Assistant',
            'name_for_model' => $storeName . '_Store_Assistant',
            'description_for_human' => 'Check order status, product information, and return policies for ' . $storeName,
            'description_for_model' => 'Plugin for checking order status by email and order ID, retrieving product information by SKU, and accessing the return policy for ' . $storeName,
            'auth' => $this->helper->isAuthRequired() ? ['type' => 'user_http', 'authorization_type' => 'bearer'] : ['type' => 'none'],
            'api' => [
                'type' => 'openapi',
                'url' => $storeUrl . 'mcp/schema/openapi',
                'has_user_authentication' => false
            ],
            'logo_url' => $storeUrl . 'media/logo/stores/1/logo.png',
            'contact_email' => 'support@example.com',
            'legal_info_url' => $storeUrl . 'privacy-policy'
        ];
        
        $result = $this->resultJsonFactory->create();
        $result->setData($manifest);
        $result->setHeader('Content-Type', 'application/json');
        
        return $result;
    }
}

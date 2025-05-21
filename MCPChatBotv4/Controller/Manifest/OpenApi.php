<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Controller\Manifest;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Store\Model\StoreManagerInterface;

class OpenApi implements HttpGetActionInterface
{
    public function __construct(
        private JsonFactory $resultJsonFactory,
        private AssetRepository $assetRepository,
        private StoreManagerInterface $storeManager
    ) {}

    public function execute()
    {
        $store = $this->storeManager->getStore();
        $schemaFile = $this->assetRepository->createAsset(
            'Spyrosoft_MCPChatBotv4::openapi.json'
        );

        $schema = json_decode(file_get_contents($schemaFile->getSourceFile()), true);
        
        // Update server URL with actual store URL
        $schema['servers'][0]['variables']['store_url']['default'] = $store->getBaseUrl();

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($schema);
    }
}

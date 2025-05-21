<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Controller\Manifest;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Store\Model\StoreManagerInterface;

class AiPlugin implements HttpGetActionInterface
{
    public function __construct(
        private JsonFactory $resultJsonFactory,
        private AssetRepository $assetRepository,
        private StoreManagerInterface $storeManager
    ) {}

    public function execute()
    {
        $store = $this->storeManager->getStore();
        $manifestFile = $this->assetRepository->createAsset(
            'Spyrosoft_MCPChatBotv4::/.well-known/ai-plugin.json'
        );

        $manifest = json_decode(file_get_contents($manifestFile->getSourceFile()), true);
        
        // Update dynamic values
        $manifest['logo_url'] = $store->getBaseUrl() . 'media/logo.png';
        $manifest['contact_email'] = $store->getConfig('trans_email/ident_support/email');
        $manifest['legal_info_url'] = $store->getBaseUrl() . 'legal';

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($manifest);
    }
}

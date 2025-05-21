<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Model;

use Spyrosoft\MCPChatBotv5\Api\ProductInfoServiceInterface;
use Spyrosoft\MCPChatBotv5\Api\Data\ProductInfoInterface;
use Spyrosoft\MCPChatBotv5\Api\Data\ProductInfoInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class ProductInfoService implements ProductInfoServiceInterface
{
    public function __construct(
        private ProductInfoInterfaceFactory $factory,
        private ProductRepositoryInterface $productRepository,
        private StoreManagerInterface $storeManager
    ) {}

    public function getProductInfo(string $sku): ProductInfoInterface
    {
        $product = $this->productRepository->get($sku);
        $info = $this->factory->create();
        $info->setSku($product->getSku());
        $info->setName($product->getName());
        $info->setPrice((float)$product->getPrice());
        $info->setCurrency($this->storeManager->getStore()->getCurrentCurrency()->getCurrencyCode());
        $stockItem = $product->getExtensionAttributes()?->getStockItem();
        $status = ($stockItem && $stockItem->getIsInStock()) ? 'in_stock' : 'out_of_stock';
        $info->setStockStatus($status);
        $info->setShortDescription((string)$product->getShortDescription());
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $info->setImageUrl($baseUrl . 'catalog/product' . $product->getSmallImage());
        $info->setCategoryIds($product->getCategoryIds());
        return $info;
    }
}

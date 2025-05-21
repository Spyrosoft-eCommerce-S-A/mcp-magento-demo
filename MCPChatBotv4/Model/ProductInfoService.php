<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Spyrosoft\MCPChatBotv4\Api\ProductInfoServiceInterface;
use Spyrosoft\MCPChatBotv4\Api\Data\ProductInfoInterface;
use Spyrosoft\MCPChatBotv4\Api\Data\ProductInfoInterfaceFactory;
use Magento\CatalogInventory\Api\StockStateInterface;

class ProductInfoService implements ProductInfoServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductInfoInterfaceFactory $productInfoFactory,
        private StoreManagerInterface $storeManager,
        private StockStateInterface $stockState
    ) {}

    public function getProductInfo(string $sku): ProductInfoInterface
    {
        try {
            $product = $this->productRepository->get($sku);
            $store = $this->storeManager->getStore();

            $productInfo = $this->productInfoFactory->create();
            $productInfo->setSku($product->getSku());
            $productInfo->setName($product->getName());
            $productInfo->setPrice($product->getFinalPrice());
            $productInfo->setCurrency($store->getCurrentCurrencyCode());
            
            // Get stock status
            $stockStatus = $this->stockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId()) > 0
                ? 'in_stock'
                : 'out_of_stock';
            $productInfo->setStockStatus($stockStatus);
            
            $productInfo->setShortDescription($product->getShortDescription() ?? '');
            
            // Get product image URL
            $imageUrl = $product->getMediaGalleryImages()->getFirstItem()
                ? $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $product->getMediaGalleryImages()->getFirstItem()->getFile()
                : '';
            $productInfo->setImageUrl($imageUrl);
            
            $productInfo->setCategoryIds($product->getCategoryIds());

            return $productInfo;
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__('Product not found.'));
        }
    }
}

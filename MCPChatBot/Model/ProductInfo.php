<?php
namespace Spyrosoft\MCPChatBot\Model;

use Spyrosoft\MCPChatBot\Api\ProductInfoInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Store\Model\StoreManagerInterface;

class ProductInfo implements ProductInfoInterface
{
    protected $productRepository;
    protected $stockRegistry;
    protected $imageHelper;
    protected $storeManager;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockRegistryInterface $stockRegistry,
        ImageHelper $imageHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
        $this->imageHelper = $imageHelper;
        $this->storeManager = $storeManager;
    }

    public function getProductInfo($sku)
    {
        try {
            $product = $this->productRepository->get($sku);
            $stockItem = $this->stockRegistry->getStockItem($product->getId());
            $imageUrl = $this->imageHelper->init($product, 'product_base_image')->getUrl();
            return [
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'price' => (float)$product->getPrice(),
                'currency' => $this->storeManager->getStore()->getCurrentCurrencyCode(),
                'stock_status' => $stockItem->getIsInStock() ? 'in_stock' : 'out_of_stock',
                'short_description' => $product->getShortDescription(),
                'image_url' => $imageUrl,
                'category_ids' => $product->getCategoryIds()
            ];
        } catch (\Exception $e) {
            return ['error' => 'Product not found.'];
        }
    }
}

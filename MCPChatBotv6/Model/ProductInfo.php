<?php
namespace Spyrosoft\MCPChatBotv6\Model;

use Spyrosoft\MCPChatBotv6\Api\ProductInfoInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductInfo implements ProductInfoInterface
{
    protected $productRepository;
    protected $stockRegistry;
    protected $categoryLinkManagement;
    protected $storeManager;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockRegistryInterface $stockRegistry,
        CategoryLinkManagementInterface $categoryLinkManagement,
        StoreManagerInterface $storeManager
    ) {
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->storeManager = $storeManager;
    }

    public function getProductInfo($sku)
    {
        try {
            $product = $this->productRepository->get($sku);
            $stock = $this->stockRegistry->getStockItem($product->getId());
            $categories = $this->categoryLinkManagement->getAssignedCategoryIds($sku);
            $imageUrl = null;
            if ($product->getImage() && $product->getImage() !== 'no_selection') {
                $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                $imageUrl = $mediaUrl . 'catalog/product' . $product->getImage();
            }
            return [
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'price' => (float)$product->getPrice(),
                'currency' => $this->storeManager->getStore()->getCurrentCurrencyCode(),
                'stock_status' => $stock->getIsInStock() ? 'in_stock' : 'out_of_stock',
                'short_description' => $product->getShortDescription(),
                'image_url' => $imageUrl,
                'category_ids' => $categories
            ];
        } catch (NoSuchEntityException $e) {
            return ['error' => 'Product not found.'];
        }
    }
}

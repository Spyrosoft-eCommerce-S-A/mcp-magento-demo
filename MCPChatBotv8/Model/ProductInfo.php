<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Model;

use Spyrosoft\MCPChatBot\Api\ProductInfoInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class ProductInfo
 */
class ProductInfo implements ProductInfoInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var StockRegistryInterface
     */
    private $stockRegistry;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var AuthValidator
     */
    private $authValidator;

    /**
     * ProductInfo constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param StockRegistryInterface $stockRegistry
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param AuthValidator $authValidator
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockRegistryInterface $stockRegistry,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        AuthValidator $authValidator
    ) {
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->authValidator = $authValidator;
    }

    /**
     * @inheritDoc
     */
    public function getProductInfo($sku)
    {
        // Check if module is enabled
        if (!$this->isModuleEnabled()) {
            throw new LocalizedException(__('MCP ChatBot module is disabled.'));
        }

        // Validate authentication if required
        $this->authValidator->validate();

        try {
            $product = $this->productRepository->get($sku);
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('Product with SKU "%1" not found.', $sku));
        }

        // Get stock status
        $stockItem = $this->stockRegistry->getStockItemBySku($sku);
        $stockStatus = $stockItem->getIsInStock() ? 'in_stock' : 'out_of_stock';

        // Get product image URL
        $imageUrl = '';
        if ($product->getImage()) {
            $store = $this->storeManager->getStore();
            $imageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) 
                . 'catalog/product' . $product->getImage();
        }

        // Get category IDs
        $categoryIds = array_map('intval', $product->getCategoryIds());

        return [
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'price' => (float)$product->getPrice(),
            'currency' => $this->storeManager->getStore()->getCurrentCurrencyCode(),
            'stock_status' => $stockStatus,
            'short_description' => $product->getShortDescription() ?: '',
            'image_url' => $imageUrl,
            'category_ids' => $categoryIds
        ];
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    private function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'spyrosoft_mcpchatbot/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }
}

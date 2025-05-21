<?php
/**
 * ProductInfo Model for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Spyrosoft\MCPChatBotv3\Api\ProductInfoInterface;
use Spyrosoft\MCPChatBotv3\Helper\Data as Helper;

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
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * ProductInfo constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     * @param Helper $helper
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        Helper $helper
    ) {
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->helper = $helper;
    }

    /**
     * Get product information by SKU
     *
     * @param string $sku Product SKU
     * @return array Product information
     * @throws LocalizedException
     */
    public function getProductInfo(string $sku): array
    {
        // Validate module is enabled
        if (!$this->helper->isEnabled()) {
            throw new LocalizedException(__('MCP ChatBot module is disabled'));
        }

        try {
            $product = $this->productRepository->get($sku);
        } catch (NoSuchEntityException $e) {
            return [
                'error' => 'Product not found',
                'status' => 404
            ];
        }

        // Get stock status
        $stockStatus = $product->isSalable() ? 'in_stock' : 'out_of_stock';
        
        // Get store URL
        $storeUrl = $this->storeManager->getStore()->getBaseUrl();
        
        // Get image URL
        $imageUrl = $storeUrl . 'media/catalog/product' . $product->getImage();
        if ($product->getImage() === 'no_selection' || empty($product->getImage())) {
            $imageUrl = '';
        }
        
        // Get category IDs
        $categoryIds = $product->getCategoryIds();
        
        // Build response
        $response = [
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'price' => (float)$product->getFinalPrice(),
            'currency' => $this->storeManager->getStore()->getCurrentCurrencyCode(),
            'stock_status' => $stockStatus,
            'short_description' => strip_tags($product->getShortDescription() ?? ''),
            'image_url' => $imageUrl,
            'category_ids' => $categoryIds ?? []
        ];
        
        return $response;
    }
}

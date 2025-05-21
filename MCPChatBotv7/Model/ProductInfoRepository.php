<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Spyrosoft\MCPChatBotv7\Api\ProductInfoRepositoryInterface;
use Spyrosoft\MCPChatBotv7\Api\Data\ProductInfoInterface;
use Spyrosoft\MCPChatBotv7\Api\Data\ProductInfoInterfaceFactory;
use Spyrosoft\MCPChatBotv7\Enum\ApiEnum;
use Magento\Store\Model\StoreManagerInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\UrlInterface;


class ProductInfoRepository implements ProductInfoRepositoryInterface
{
    private ProductRepositoryInterface $productRepository;
    private ProductInfoInterfaceFactory $productInfoFactory;
    private StoreManagerInterface $storeManager;
    private StockRegistryInterface $stockRegistry;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductInfoInterfaceFactory $productInfoFactory,
        StoreManagerInterface $storeManager,
        StockRegistryInterface $stockRegistry
    ) {
        $this->productRepository = $productRepository;
        $this->productInfoFactory = $productInfoFactory;
        $this->storeManager = $storeManager;
        $this->stockRegistry = $stockRegistry;
    }

    public function getProductInfo(string $sku): ProductInfoInterface
    {
        try {
            $product = $this->productRepository->get($sku);
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('Product with SKU "%1" not found.', $sku), $e);
        }

        $productInfo = $this->productInfoFactory->create();
        $productInfo->setSku($product->getSku());
        $productInfo->setName($product->getName());
        $productInfo->setPrice(
            (float)$product->getPriceInfo()
                ->getPrice(ApiEnum::FINAL_PRICE)
                ->getValue()
        );
        $productInfo->setCurrency(
            $this->storeManager
                ->getStore()
                ->getCurrentCurrency()
                ->getCode()
        );

        $stockItem = $this->stockRegistry->getStockItem(
            $product->getId(),
            $product->getStore()->getWebsiteId()
        );
        $productInfo->setStockStatus(
            $stockItem->getIsInStock() ? ApiEnum::IN_STOCK : ApiEnum::OUT_OF_STOCK
        );

        $productInfo->setShortDescription($product->getShortDescription());

        $imageUrl = null;
        if ($product->getImage()) {
            $imageUrl = $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                . 'catalog/product' . $product->getImage();
        }
        $productInfo->setImageUrl($imageUrl);
        $productInfo->setCategoryIds($product->getCategoryIds());

        return $productInfo;
    }
}

<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Model\Data;

use Spyrosoft\MCPChatBotv7\Api\Data\ProductInfoInterface;
use Spyrosoft\MCPChatBotv7\Enum\ApiEnum;
use Magento\Framework\Model\AbstractExtensibleModel;

class ProductInfo extends AbstractExtensibleModel implements ProductInfoInterface
{
    public function getSku(): string
    {
        return (string)$this->getData(ApiEnum::SKU);
    }

    public function setSku(string $sku): self
    {
        return $this->setData(ApiEnum::SKU, $sku);
    }

    public function getName(): string
    {
        return (string)$this->getData(ApiEnum::NAME);
    }

    public function setName(string $name): self
    {
        return $this->setData(ApiEnum::NAME, $name);
    }

    public function getPrice(): float
    {
        return (float)$this->getData(ApiEnum::PRICE);
    }

    public function setPrice(float $price): self
    {
        return $this->setData(ApiEnum::PRICE, $price);
    }

    public function getCurrency(): string
    {
        return (string)$this->getData(ApiEnum::CURRENCY);
    }

    public function setCurrency(string $currency): self
    {
        return $this->setData(ApiEnum::CURRENCY, $currency);
    }

    public function getStockStatus(): string
    {
        return (string)$this->getData(ApiEnum::STOCK_STATUS);
    }

    public function setStockStatus(string $stockStatus): self
    {
        return $this->setData(ApiEnum::STOCK_STATUS, $stockStatus);
    }

    public function getShortDescription(): ?string
    {
        return $this->getData(ApiEnum::SHORT_DESCRIPTION) === null ? null : (string)$this->getData(ApiEnum::SHORT_DESCRIPTION);
    }

    public function setShortDescription(?string $shortDescription): self
    {
        return $this->setData(ApiEnum::SHORT_DESCRIPTION, $shortDescription);
    }

    public function getImageUrl(): ?string
    {
        return $this->getData(ApiEnum::IMAGE_URL) === null ? null : (string)$this->getData(ApiEnum::IMAGE_URL);
    }

    public function setImageUrl(?string $imageUrl): self
    {
        return $this->setData(ApiEnum::IMAGE_URL, $imageUrl);
    }

    public function getCategoryIds(): ?array
    {
        return $this->getData(ApiEnum::CATEGORY_IDS) === null ? null : (array)$this->getData(ApiEnum::CATEGORY_IDS);
    }

    public function setCategoryIds(?array $categoryIds): self
    {
        return $this->setData(ApiEnum::CATEGORY_IDS, $categoryIds);
    }
}

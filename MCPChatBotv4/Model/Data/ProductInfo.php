<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Model\Data;

use Spyrosoft\MCPChatBotv4\Api\Data\ProductInfoInterface;
use Magento\Framework\DataObject;

class ProductInfo extends DataObject implements ProductInfoInterface
{
    public function getSku(): string
    {
        return $this->getData('sku');
    }

    public function getName(): string
    {
        return $this->getData('name');
    }

    public function getPrice(): float
    {
        return (float)$this->getData('price');
    }

    public function getCurrency(): string
    {
        return $this->getData('currency');
    }

    public function getStockStatus(): string
    {
        return $this->getData('stock_status');
    }

    public function getShortDescription(): string
    {
        return $this->getData('short_description');
    }

    public function getImageUrl(): string
    {
        return $this->getData('image_url');
    }

    public function getCategoryIds(): array
    {
        return $this->getData('category_ids') ?? [];
    }

    public function setSku(string $sku): void
    {
        $this->setData('sku', $sku);
    }

    public function setName(string $name): void
    {
        $this->setData('name', $name);
    }

    public function setPrice(float $price): void
    {
        $this->setData('price', $price);
    }

    public function setCurrency(string $currency): void
    {
        $this->setData('currency', $currency);
    }

    public function setStockStatus(string $status): void
    {
        $this->setData('stock_status', $status);
    }

    public function setShortDescription(string $description): void
    {
        $this->setData('short_description', $description);
    }

    public function setImageUrl(string $url): void
    {
        $this->setData('image_url', $url);
    }

    public function setCategoryIds(array $categoryIds): void
    {
        $this->setData('category_ids', $categoryIds);
    }
}

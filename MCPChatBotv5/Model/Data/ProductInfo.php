<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Model\Data;

use Spyrosoft\MCPChatBotv5\Api\Data\ProductInfoInterface;
use Magento\Framework\DataObject;

class ProductInfo extends DataObject implements ProductInfoInterface
{
    public function getSku(): string
    {
        return (string)$this->getData('sku');
    }
    public function setSku(string $sku): void
    {
        $this->setData('sku', $sku);
    }
    public function getName(): string
    {
        return (string)$this->getData('name');
    }
    public function setName(string $name): void
    {
        $this->setData('name', $name);
    }
    public function getPrice(): float
    {
        return (float)$this->getData('price');
    }
    public function setPrice(float $price): void
    {
        $this->setData('price', $price);
    }
    public function getCurrency(): string
    {
        return (string)$this->getData('currency');
    }
    public function setCurrency(string $currency): void
    {
        $this->setData('currency', $currency);
    }
    public function getStockStatus(): string
    {
        return (string)$this->getData('stock_status');
    }
    public function setStockStatus(string $status): void
    {
        $this->setData('stock_status', $status);
    }
    public function getShortDescription(): string
    {
        return (string)$this->getData('short_description');
    }
    public function setShortDescription(string $desc): void
    {
        $this->setData('short_description', $desc);
    }
    public function getImageUrl(): string
    {
        return (string)$this->getData('image_url');
    }
    public function setImageUrl(string $url): void
    {
        $this->setData('image_url', $url);
    }
    public function getCategoryIds(): array
    {
        return (array)$this->getData('category_ids');
    }
    public function setCategoryIds(array $ids): void
    {
        $this->setData('category_ids', $ids);
    }
}

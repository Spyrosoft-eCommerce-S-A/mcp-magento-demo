<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Model\Data;

use Spyrosoft\MCPChatBotv4\Api\Data\OrderStatusInterface;
use Magento\Framework\DataObject;

class OrderStatus extends DataObject implements OrderStatusInterface
{
    public function getOrderId(): string
    {
        return $this->getData('order_id');
    }

    public function getStatus(): string
    {
        return $this->getData('status');
    }

    public function getShipmentTracking(): ?string
    {
        return $this->getData('shipment_tracking');
    }

    public function getTotal(): float
    {
        return (float)$this->getData('total');
    }

    public function getCurrency(): string
    {
        return $this->getData('currency');
    }

    public function getCreatedAt(): string
    {
        return $this->getData('created_at');
    }

    public function getItems(): array
    {
        return $this->getData('items') ?? [];
    }

    public function setOrderId(string $orderId): void
    {
        $this->setData('order_id', $orderId);
    }

    public function setStatus(string $status): void
    {
        $this->setData('status', $status);
    }

    public function setShipmentTracking(?string $tracking): void
    {
        $this->setData('shipment_tracking', $tracking);
    }

    public function setTotal(float $total): void
    {
        $this->setData('total', $total);
    }

    public function setCurrency(string $currency): void
    {
        $this->setData('currency', $currency);
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->setData('created_at', $createdAt);
    }

    public function setItems(array $items): void
    {
        $this->setData('items', $items);
    }
}

<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Model\Data;

use Spyrosoft\MCPChatBotv5\Api\Data\OrderStatusInterface;
use Magento\Framework\DataObject;

class OrderStatus extends DataObject implements OrderStatusInterface
{
    public function getOrderId(): string
    {
        return (string)$this->getData('order_id');
    }

    public function setOrderId(string $id): void
    {
        $this->setData('order_id', $id);
    }

    public function getStatus(): string
    {
        return (string)$this->getData('status');
    }

    public function setStatus(string $status): void
    {
        $this->setData('status', $status);
    }

    public function getShipmentTracking(): ?string
    {
        return $this->getData('shipment_tracking');
    }

    public function setShipmentTracking(?string $tracking): void
    {
        $this->setData('shipment_tracking', $tracking);
    }

    public function getTotal(): float
    {
        return (float)$this->getData('total');
    }

    public function setTotal(float $total): void
    {
        $this->setData('total', $total);
    }

    public function getCurrency(): string
    {
        return (string)$this->getData('currency');
    }

    public function setCurrency(string $currency): void
    {
        $this->setData('currency', $currency);
    }

    public function getCreatedAt(): string
    {
        return (string)$this->getData('created_at');
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->setData('created_at', $createdAt);
    }

    public function getItems(): array
    {
        return (array)$this->getData('items');
    }

    public function setItems(array $items): void
    {
        $this->setData('items', $items);
    }
}

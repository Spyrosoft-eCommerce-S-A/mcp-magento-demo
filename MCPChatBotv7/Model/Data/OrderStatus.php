<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Model\Data;

use Spyrosoft\MCPChatBotv7\Api\Data\OrderStatusInterface;
use Spyrosoft\MCPChatBotv7\Api\Data\OrderItemInterface;
use Spyrosoft\MCPChatBotv7\Enum\ApiEnum;
use Magento\Framework\Model\AbstractExtensibleModel;

class OrderStatus extends AbstractExtensibleModel implements OrderStatusInterface
{
    public function getOrderId(): string
    {
        return (string)$this->getData(ApiEnum::ORDER_ID);
    }

    public function setOrderId(string $orderId): self
    {
        return $this->setData(ApiEnum::ORDER_ID, $orderId);
    }

    public function getStatus(): string
    {
        return (string)$this->getData(ApiEnum::STATUS);
    }

    public function setStatus(string $status): self
    {
        return $this->setData(ApiEnum::STATUS, $status);
    }

    public function getShipmentTracking(): ?string
    {
        return $this->getData(ApiEnum::SHIPMENT_TRACKING) === null ? null : (string)$this->getData(ApiEnum::SHIPMENT_TRACKING);
    }

    public function setShipmentTracking(?string $shipmentTracking): self
    {
        return $this->setData(ApiEnum::SHIPMENT_TRACKING, $shipmentTracking);
    }

    public function getTotal(): float
    {
        return (float)$this->getData(ApiEnum::TOTAL);
    }

    public function setTotal(float $total): self
    {
        return $this->setData(ApiEnum::TOTAL, $total);
    }

    public function getCurrency(): string
    {
        return (string)$this->getData(ApiEnum::CURRENCY);
    }

    public function setCurrency(string $currency): self
    {
        return $this->setData(ApiEnum::CURRENCY, $currency);
    }

    public function getCreatedAt(): string
    {
        return (string)$this->getData(ApiEnum::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): self
    {
        return $this->setData(ApiEnum::CREATED_AT, $createdAt);
    }

    /**
     * @return OrderItemInterface[]
     */
    public function getItems(): array
    {
        return [];
    }

    /**
     * @param OrderItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self
    {
        return $this;
    }
}

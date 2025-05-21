<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Api\Data;

use Spyrosoft\MCPChatBotv7\Api\Data\OrderItemInterface;

/**
 * @api
 */
interface OrderStatusInterface
{

    /**
     * @return string
     */
    public function getOrderId(): string;

    /**
     * @param string $orderId
     * @return $this
     */
    public function setOrderId(string $orderId): self;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self;

    /**
     * @return string|null
     */
    public function getShipmentTracking(): ?string;

    /**
     * @param string|null $shipmentTracking
     * @return $this
     */
    public function setShipmentTracking(?string $shipmentTracking): self;

    /**
     * @return float
     */
    public function getTotal(): float;

    /**
     * @param float $total
     * @return $this
     */
    public function setTotal(float $total): self;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency(string $currency): self;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;

    /**
     * @return OrderItemInterface[]
     */
    public function getItems(): array;

    /**
     * @param OrderItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self;
}
    
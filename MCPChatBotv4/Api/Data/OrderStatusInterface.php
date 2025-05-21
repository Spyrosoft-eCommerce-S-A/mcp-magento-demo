<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Api\Data;

interface OrderStatusInterface
{
    /**
     * @return string
     */
    public function getOrderId(): string;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return string|null
     */
    public function getShipmentTracking(): ?string;

    /**
     * @return float
     */
    public function getTotal(): float;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return \Spyrosoft\MCPChatBotv4\Api\Data\OrderItemInterface[]
     */
    public function getItems(): array;

    /**
     * @param string $orderId
     * @return void
     */
    public function setOrderId(string $orderId): void;

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void;

    /**
     * @param string|null $tracking
     * @return void
     */
    public function setShipmentTracking(?string $tracking): void;

    /**
     * @param float $total
     * @return void
     */
    public function setTotal(float $total): void;

    /**
     * @param string $currency
     * @return void
     */
    public function setCurrency(string $currency): void;

    /**
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void;

    /**
     * @param \Spyrosoft\MCPChatBotv4\Api\Data\OrderItemInterface[] $items
     * @return void
     */
    public function setItems(array $items): void;
}

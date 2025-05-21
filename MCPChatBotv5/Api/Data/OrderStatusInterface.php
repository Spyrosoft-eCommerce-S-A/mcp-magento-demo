<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Api\Data;

interface OrderStatusInterface
{
    public function getOrderId(): string;
    public function setOrderId(string $id): void;

    public function getStatus(): string;
    public function setStatus(string $status): void;

    public function getShipmentTracking(): ?string;
    public function setShipmentTracking(?string $tracking): void;

    public function getTotal(): float;
    public function setTotal(float $total): void;

    public function getCurrency(): string;
    public function setCurrency(string $currency): void;

    public function getCreatedAt(): string;
    public function setCreatedAt(string $createdAt): void;

    public function getItems(): array;
    public function setItems(array $items): void;
}

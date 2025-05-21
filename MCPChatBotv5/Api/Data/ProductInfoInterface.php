<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Api\Data;

interface ProductInfoInterface
{
    public function getSku(): string;
    public function setSku(string $sku): void;

    public function getName(): string;
    public function setName(string $name): void;

    public function getPrice(): float;
    public function setPrice(float $price): void;

    public function getCurrency(): string;
    public function setCurrency(string $currency): void;

    public function getStockStatus(): string;
    public function setStockStatus(string $status): void;

    public function getShortDescription(): string;
    public function setShortDescription(string $desc): void;

    public function getImageUrl(): string;
    public function setImageUrl(string $url): void;

    public function getCategoryIds(): array;
    public function setCategoryIds(array $ids): void;
}

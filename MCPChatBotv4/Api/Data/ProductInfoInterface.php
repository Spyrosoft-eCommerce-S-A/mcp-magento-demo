<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Api\Data;

interface ProductInfoInterface
{
    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @return string
     */
    public function getStockStatus(): string;

    /**
     * @return string
     */
    public function getShortDescription(): string;

    /**
     * @return string
     */
    public function getImageUrl(): string;

    /**
     * @return int[]
     */
    public function getCategoryIds(): array;

    /**
     * @param string $sku
     * @return void
     */
    public function setSku(string $sku): void;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @param float $price
     * @return void
     */
    public function setPrice(float $price): void;

    /**
     * @param string $currency
     * @return void
     */
    public function setCurrency(string $currency): void;

    /**
     * @param string $status
     * @return void
     */
    public function setStockStatus(string $status): void;

    /**
     * @param string $description
     * @return void
     */
    public function setShortDescription(string $description): void;

    /**
     * @param string $url
     * @return void
     */
    public function setImageUrl(string $url): void;

    /**
     * @param int[] $categoryIds
     * @return void
     */
    public function setCategoryIds(array $categoryIds): void;
}

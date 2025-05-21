<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Api\Data;

/**
 * @api
 */
interface ProductInfoInterface
{

    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku): self;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): self;

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
    public function getStockStatus(): string;

    /**
     * @param string $stockStatus
     * @return $this
     */
    public function setStockStatus(string $stockStatus): self;

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string;

    /**
     * @param string|null $shortDescription
     * @return $this
     */
    public function setShortDescription(?string $shortDescription): self;

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string;

    /**
     * @param string|null $imageUrl
     * @return $this
     */
    public function setImageUrl(?string $imageUrl): self;

    /**
     * @return int[]|null
     */
    public function getCategoryIds(): ?array;

    /**
     * @param int[]|null $categoryIds
     * @return $this
     */
    public function setCategoryIds(?array $categoryIds): self;
}

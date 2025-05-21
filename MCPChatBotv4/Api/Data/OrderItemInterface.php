<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Api\Data;

interface OrderItemInterface
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
     * @return int
     */
    public function getQty(): int;

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
     * @param int $qty
     * @return void
     */
    public function setQty(int $qty): void;
}

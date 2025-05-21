<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Api\Data;

/**
 * @api
 */
interface OrderItemInterface
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
     * @return int
     */
    public function getQty(): int;

    /**
     * @param int $qty
     * @return $this
     */
    public function setQty(int $qty): self;
}
    
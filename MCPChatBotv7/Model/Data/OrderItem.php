<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Model\Data;

use Spyrosoft\MCPChatBotv7\Api\Data\OrderItemInterface;
use Spyrosoft\MCPChatBotv7\Enum\ApiEnum;
use Magento\Framework\Model\AbstractExtensibleModel;


class OrderItem extends AbstractExtensibleModel implements OrderItemInterface
{
    /**
     * @inheritDoc
     */
    public function getSku(): string
    {
        return (string)$this->_get(ApiEnum::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setSku(string $sku): self
    {
        return $this->setData(ApiEnum::SKU, $sku);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return (string)$this->_get(ApiEnum::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): self
    {
        return $this->setData(ApiEnum::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getQty(): int
    {
        return (int)$this->_get(ApiEnum::QTY);
    }

    /**
     * @inheritDoc
     */
    public function setQty(int $qty): self
    {
        return $this->setData(ApiEnum::QTY, $qty);
    }
}

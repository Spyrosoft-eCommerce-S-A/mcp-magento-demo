<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Model\Data;

use Spyrosoft\MCPChatBotv4\Api\Data\OrderItemInterface;
use Magento\Framework\DataObject;

class OrderItem extends DataObject implements OrderItemInterface
{
    public function getSku(): string
    {
        return $this->getData('sku');
    }

    public function getName(): string
    {
        return $this->getData('name');
    }

    public function getQty(): int
    {
        return (int)$this->getData('qty');
    }

    public function setSku(string $sku): void
    {
        $this->setData('sku', $sku);
    }

    public function setName(string $name): void
    {
        $this->setData('name', $name);
    }

    public function setQty(int $qty): void
    {
        $this->setData('qty', $qty);
    }
}

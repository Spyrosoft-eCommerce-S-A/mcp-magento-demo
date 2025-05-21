<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Api;

use Spyrosoft\MCPChatBotv7\Api\Data\OrderStatusInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @api
 */
interface OrderStatusRepositoryInterface
{
    /**
     * @param string $email
     * @param string $orderId
     * @return OrderStatusInterface
     * @throws NoSuchEntityException
     */
    public function getOrderStatus(string $email, string $orderId): OrderStatusInterface;
}

<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Api;

use Spyrosoft\MCPChatBotv5\Api\Data\OrderStatusInterface;

interface OrderStatusServiceInterface
{
    /**
     * Get an order by customer email and order ID
     * @param string $email
     * @param string $orderId
     * @return OrderStatusInterface
     */
    public function getOrderStatus(string $email, string $orderId): OrderStatusInterface;
}

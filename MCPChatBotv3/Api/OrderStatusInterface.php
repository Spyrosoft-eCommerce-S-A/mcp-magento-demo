<?php
/**
 * OrderStatusInterface for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Api;

/**
 * Interface OrderStatusInterface
 */
interface OrderStatusInterface
{
    /**
     * Get order status by email and order ID
     *
     * @param string $email Customer email
     * @param string $orderId Order ID
     * @return array Order status data
     */
    public function getOrderStatus(string $email, string $orderId): array;
}

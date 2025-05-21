<?php
namespace Spyrosoft\MCPChatBot\Api;

interface OrderStatusInterface
{
    /**
     * Get order status by email and order ID
     * @param string $email
     * @param string $orderId
     * @return array
     */
    public function getOrderStatus($email, $orderId);
}

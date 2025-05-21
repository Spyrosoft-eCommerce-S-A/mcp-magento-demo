<?php
namespace Spyrosoft\MCPChatBotv2\Api;

interface OrderStatusInterface
{
    /**
     * GET order status by email and order ID
     * @param string $email
     * @param string $orderId
     * @return array
     */
    public function getOrderStatus($email, $orderId);
}

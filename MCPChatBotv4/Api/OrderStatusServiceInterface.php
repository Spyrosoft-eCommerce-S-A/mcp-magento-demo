<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Api;

interface OrderStatusServiceInterface
{
    /**
     * Get order status by email and order ID
     * 
     * @param string $email Customer email
     * @param string $orderId Order ID
     * @return \Spyrosoft\MCPChatBotv4\Api\Data\OrderStatusInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getOrderStatus(string $email, string $orderId): \Spyrosoft\MCPChatBotv4\Api\Data\OrderStatusInterface;
}

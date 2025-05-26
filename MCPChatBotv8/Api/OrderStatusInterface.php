<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Api;

/**
 * Interface OrderStatusInterface
 * @api
 */
interface OrderStatusInterface
{
    /**
     * Get order status by email and order ID
     *
     * @param string $email
     * @param string $orderId
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOrderStatus($email, $orderId);
}

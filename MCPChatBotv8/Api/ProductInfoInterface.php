<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Api;

/**
 * Interface ProductInfoInterface
 * @api
 */
interface ProductInfoInterface
{
    /**
     * Get product information by SKU
     *
     * @param string $sku
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductInfo($sku);
}

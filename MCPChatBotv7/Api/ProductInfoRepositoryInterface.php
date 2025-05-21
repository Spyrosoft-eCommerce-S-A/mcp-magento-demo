<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Api;

use Spyrosoft\MCPChatBotv7\Api\Data\ProductInfoInterface;

/**
 * Interface ProductInfoRepositoryInterface
 * @api
 */
interface ProductInfoRepositoryInterface
{
    /**
     * Get product info by SKU
     *
     * @param string $sku
     * @return \Spyrosoft\MCPChatBotv7\Api\Data\ProductInfoInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductInfo(string $sku): ProductInfoInterface;
}

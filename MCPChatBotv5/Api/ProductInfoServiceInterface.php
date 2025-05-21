<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Api;

use Spyrosoft\MCPChatBotv5\Api\Data\ProductInfoInterface;

interface ProductInfoServiceInterface
{
    /**
     * Get product information by SKU
     * @param string $sku
     * @return ProductInfoInterface
     */
    public function getProductInfo(string $sku): ProductInfoInterface;
}

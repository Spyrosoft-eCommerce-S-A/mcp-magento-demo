<?php
namespace Spyrosoft\MCPChatBotv6\Api;

interface ProductInfoInterface
{
    /**
     * Get product info by SKU
     * @param string $sku
     * @return array
     */
    public function getProductInfo($sku);
}

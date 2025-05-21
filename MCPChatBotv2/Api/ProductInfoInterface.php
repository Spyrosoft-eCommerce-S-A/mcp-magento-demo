<?php
namespace Spyrosoft\MCPChatBotv2\Api;

interface ProductInfoInterface
{
    /**
     * GET product info by SKU
     * @param string $sku
     * @return array
     */
    public function getProductInfo($sku);
}

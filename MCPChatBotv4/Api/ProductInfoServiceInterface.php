<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Api;

interface ProductInfoServiceInterface
{
    /**
     * Get product information by SKU
     * 
     * @param string $sku Product SKU
     * @return \Spyrosoft\MCPChatBotv4\Api\Data\ProductInfoInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductInfo(string $sku): \Spyrosoft\MCPChatBotv4\Api\Data\ProductInfoInterface;
}

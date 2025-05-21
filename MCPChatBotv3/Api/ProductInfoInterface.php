<?php
/**
 * ProductInfoInterface for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Api;

/**
 * Interface ProductInfoInterface
 */
interface ProductInfoInterface
{
    /**
     * Get product information by SKU
     *
     * @param string $sku Product SKU
     * @return array Product information
     */
    public function getProductInfo(string $sku): array;
}

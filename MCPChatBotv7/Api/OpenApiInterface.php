<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Api;

/**
 * Interface OpenApiInterface
 * @api
 */
interface OpenApiInterface
{
    /**
     * Get OpenAPI Specification
     *
     * @return string
     */
    public function getOpenApiSpec(): string;
}

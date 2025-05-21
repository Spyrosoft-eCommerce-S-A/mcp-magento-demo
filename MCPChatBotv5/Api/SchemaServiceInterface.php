<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Api;

interface SchemaServiceInterface
{
    /**
     * Return the OpenAPI schema as an associative array
     * @return array<string, mixed>
     */
    public function getSchema(): array;
}

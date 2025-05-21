<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Api;

interface ManifestServiceInterface
{
    /**
     * Return the AI plugin manifest data as associative array
     * @return array<string, mixed>
     */
    public function getManifest(): array;
}

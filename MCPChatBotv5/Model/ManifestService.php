<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Model;

use Spyrosoft\MCPChatBotv5\Api\ManifestServiceInterface;

class ManifestService implements ManifestServiceInterface
{
    public function getManifest(): array
    {
        $file = __DIR__ . '/../etc/ai-plugin.json';
        if (!file_exists($file)) {
            return [];
        }
        $json = file_get_contents($file);
        return json_decode($json, true) ?: [];
    }
}

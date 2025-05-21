<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Model;

use Spyrosoft\MCPChatBotv5\Api\SchemaServiceInterface;
use Magento\Framework\Filesystem\Driver\File as FileDriver;

class SchemaService implements SchemaServiceInterface
{
    private const SCHEMA_FILE = __DIR__ . '/../etc/schema/openapi.json';

    public function __construct(
        private FileDriver $fileDriver
    ) {}

    public function getSchema(): array
    {
        if (!$this->fileDriver->isExists(self::SCHEMA_FILE)) {
            return [];
        }
        $content = $this->fileDriver->fileGetContents(self::SCHEMA_FILE);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }
}

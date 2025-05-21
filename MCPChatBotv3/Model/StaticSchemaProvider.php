<?php
/**
 * Static OpenAPI Schema Provider for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Model;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;

/**
 * Class StaticSchemaProvider
 */
class StaticSchemaProvider
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ReadInterface
     */
    private $moduleReader;

    /**
     * StaticSchemaProvider constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
    }

    /**
     * Get static OpenAPI schema
     *
     * @return array
     * @throws FileSystemException
     */
    public function getSchema(): array
    {
        $openApiPath = $this->getStaticFilesDir() . 'openapi.json';
        
        if (file_exists($openApiPath)) {
            $schemaJson = file_get_contents($openApiPath);
            if ($schemaJson) {
                return json_decode($schemaJson, true) ?: [];
            }
        }
        
        return [];
    }

    /**
     * Get static AI plugin manifest
     *
     * @return array
     * @throws FileSystemException
     */
    public function getAiPluginManifest(): array
    {
        $manifestPath = $this->getStaticFilesDir() . 'ai-plugin.json';
        
        if (file_exists($manifestPath)) {
            $manifestJson = file_get_contents($manifestPath);
            if ($manifestJson) {
                return json_decode($manifestJson, true) ?: [];
            }
        }
        
        return [];
    }
    
    /**
     * Get static files directory
     *
     * @return string
     * @throws FileSystemException
     */
    private function getStaticFilesDir(): string
    {
        // Return path to module's static directory
        $pubDir = $this->filesystem->getDirectoryRead(DirectoryList::PUB)->getAbsolutePath();
        return $pubDir . 'static/mcp/';
    }
}

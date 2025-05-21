<?php
/**
 * ReturnPolicyInterface for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Api;

/**
 * Interface ReturnPolicyInterface
 */
interface ReturnPolicyInterface
{
    /**
     * Get store's return policy
     *
     * @return array Return policy data
     */
    public function getReturnPolicy(): array;
}

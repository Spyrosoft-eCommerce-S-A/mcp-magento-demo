<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Api;

use Spyrosoft\MCPChatBotv7\Api\Data\ReturnPolicyInterface;

/**
 * Interface ReturnPolicyRepositoryInterface
 * @api
 */
interface ReturnPolicyRepositoryInterface
{
    /**
     * Get return policy
     *
     * @return \Spyrosoft\MCPChatBotv7\Api\Data\ReturnPolicyInterface
     */
    public function getReturnPolicy(): ReturnPolicyInterface;
}

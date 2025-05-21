<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Api;

use Spyrosoft\MCPChatBotv5\Api\Data\ReturnPolicyInterface;

interface ReturnPolicyServiceInterface
{
    /**
     * Get the store's return policy
     * @return ReturnPolicyInterface
     */
    public function getReturnPolicy(): ReturnPolicyInterface;
}

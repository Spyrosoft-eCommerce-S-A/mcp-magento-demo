<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Api;

interface ReturnPolicyServiceInterface
{
    /**
     * Get store return policy
     * 
     * @return \Spyrosoft\MCPChatBotv4\Api\Data\ReturnPolicyInterface
     */
    public function getReturnPolicy(): \Spyrosoft\MCPChatBotv4\Api\Data\ReturnPolicyInterface;
}

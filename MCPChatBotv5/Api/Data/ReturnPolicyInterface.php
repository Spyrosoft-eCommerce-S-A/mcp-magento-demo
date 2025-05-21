<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Api\Data;

interface ReturnPolicyInterface
{
    /**
     * Get the return policy text
     * @return string
     */
    public function getPolicyText(): string;

    /**
     * Set the return policy text
     * @param string $text
     */
    public function setPolicyText(string $text): void;
}

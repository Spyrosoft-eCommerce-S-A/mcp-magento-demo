<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Api\Data;

interface ReturnPolicyInterface
{
    /**
     * @return string
     */
    public function getPolicyText(): string;

    /**
     * @param string $text
     * @return void
     */
    public function setPolicyText(string $text): void;
}

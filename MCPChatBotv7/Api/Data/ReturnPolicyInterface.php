<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Api\Data;

/**
  * @api
 */
interface ReturnPolicyInterface
{
    /**
     * @return string
     */
    public function getPolicyText(): string;

    /**
     * @param string $policyText
     * @return $this
     */
    public function setPolicyText(string $policyText): self;
}

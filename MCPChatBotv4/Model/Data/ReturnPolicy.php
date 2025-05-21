<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Model\Data;

use Spyrosoft\MCPChatBotv4\Api\Data\ReturnPolicyInterface;
use Magento\Framework\DataObject;

class ReturnPolicy extends DataObject implements ReturnPolicyInterface
{
    public function getPolicyText(): string
    {
        return $this->getData('policy_text');
    }

    public function setPolicyText(string $text): void
    {
        $this->setData('policy_text', $text);
    }
}

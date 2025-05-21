<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Model\Data;

use Spyrosoft\MCPChatBotv7\Api\Data\ReturnPolicyInterface;
use Spyrosoft\MCPChatBotv7\Enum\ApiEnum;
use Magento\Framework\Model\AbstractExtensibleModel;

class ReturnPolicy extends AbstractExtensibleModel implements ReturnPolicyInterface
{
    public function getPolicyText(): string
    {
        return (string)$this->_get(ApiEnum::POLICY_TEXT);
    }

    public function setPolicyText(string $policyText): self
    {
        return $this->setData(ApiEnum::POLICY_TEXT, $policyText);
    }
}

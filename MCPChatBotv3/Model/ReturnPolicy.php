<?php
/**
 * ReturnPolicy Model for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Model;

use Magento\Framework\Exception\LocalizedException;
use Spyrosoft\MCPChatBotv3\Api\ReturnPolicyInterface;
use Spyrosoft\MCPChatBotv3\Helper\Data as Helper;

/**
 * Class ReturnPolicy
 */
class ReturnPolicy implements ReturnPolicyInterface
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * ReturnPolicy constructor.
     *
     * @param Helper $helper
     */
    public function __construct(
        Helper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Get store's return policy
     *
     * @return array Return policy data
     * @throws LocalizedException
     */
    public function getReturnPolicy(): array
    {
        // Validate module is enabled
        if (!$this->helper->isEnabled()) {
            throw new LocalizedException(__('MCP ChatBot module is disabled'));
        }

        return [
            'policy_text' => $this->helper->getReturnPolicy()
        ];
    }
}

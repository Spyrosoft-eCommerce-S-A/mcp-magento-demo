<?php
/**
 * Well-known AI Plugin manifest controller for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Controller\Wellknown;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;

/**
 * Class AiPlugin
 */
class AiPlugin implements HttpGetActionInterface
{
    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * AiPlugin constructor.
     *
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
    }

    /**
     * Forward to the manifest controller
     * This is used for the .well-known/ai-plugin.json endpoint
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        $resultForward->setModule('mcp')
            ->setController('manifest')
            ->setParams([])
            ->forward('plugin');
            
        return $resultForward;
    }
}

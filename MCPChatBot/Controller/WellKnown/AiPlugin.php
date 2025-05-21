<?php
namespace Spyrosoft\MCPChatBot\Controller\WellKnown;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Filesystem\DirectoryList;

class AiPlugin extends Action
{
    protected $resultRawFactory;
    protected $directoryList;

    public function __construct(
        Context $context,
        RawFactory $resultRawFactory,
        DirectoryList $directoryList
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->directoryList = $directoryList;
    }

    public function execute()
    {
        $file = $this->directoryList->getRoot() . '/app/code/Spyrosoft/MCPChatBot/.well-known/ai-plugin.json';
        $resultRaw = $this->resultRawFactory->create();
        $resultRaw->setHeader('Content-Type', 'application/json', true);
        $resultRaw->setContents(file_get_contents($file));
        return $resultRaw;
    }
}

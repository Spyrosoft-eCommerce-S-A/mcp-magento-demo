<?php
namespace Spyrosoft\MCPChatBotv6\Controller\.well-known;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\App\ResponseInterface;

class Aiplugin extends Action
{
    protected $resultRawFactory;

    public function __construct(Context $context, RawFactory $resultRawFactory)
    {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
    }

    public function execute()
    {
        $resultRaw = $this->resultRawFactory->create();
        $file = BP . '/app/code/Spyrosoft/MCPChatBotv6/view/frontend/web/.well-known/ai-plugin.json';
        if (file_exists($file)) {
            $resultRaw->setHeader('Content-Type', 'application/json', true);
            $resultRaw->setContents(file_get_contents($file));
        } else {
            $resultRaw->setHttpResponseCode(404);
            $resultRaw->setContents('{"error":"Not found"}');
        }
        return $resultRaw;
    }
}

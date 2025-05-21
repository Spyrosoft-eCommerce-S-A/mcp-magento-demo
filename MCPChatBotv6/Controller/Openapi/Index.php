<?php
namespace Spyrosoft\MCPChatBotv6\Controller\Openapi;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;

class Index extends Action
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
        $file = BP . '/app/code/Spyrosoft/MCPChatBotv6/view/frontend/web/openapi.json';
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

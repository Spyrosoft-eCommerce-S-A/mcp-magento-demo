<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Controller\Plugin;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class AiPlugin implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        JsonFactory $jsonFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();

        $pluginManifest = [
            "schema_version" => "v1",
            "name_for_model" => "magento_mcp_chatbot",
            "name_for_human" => "Magento MCP ChatBot",
            "description_for_model" => "Plugin for accessing Magento 2 store data including order status, product information, and return policies through MCP-compliant REST API endpoints.",
            "description_for_human" => "Access your Magento store data including orders, products, and policies.",
            "auth" => [
                "type" => "bearer",
                "verification_tokens" => [
                    "openai" => $this->scopeConfig->getValue(
                        'mcpchatbot/general/bearer_token',
                        ScopeInterface::SCOPE_STORE
                    ) ?: "default-bearer-token"
                ]
            ],
            "api" => [
                "type" => "openapi",
                "url" => "/mcpchatbot/openapi/schema"
            ],
            "logo_url" => "/pub/static/frontend/_default/_default/images/logo.svg",
            "contact_email" => "support@spyrosoft.com",
            "legal_info_url" => "/privacy-policy"
        ];

        $result->setData($pluginManifest);
        $result->setHeader('Content-Type', 'application/json');
        $result->setHeader('Access-Control-Allow-Origin', '*');
        
        return $result;
    }
}

<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Controller\Openapi;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Schema implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        JsonFactory $jsonFactory,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();
        $baseUrl = $this->storeManager->getStore()->getBaseUrl();

        $openApiSchema = [
            "openapi" => "3.0.0",
            "info" => [
                "title" => "Magento MCP ChatBot API",
                "description" => "MCP-compliant REST API for accessing Magento 2 store data including order status, product information, and return policies.",
                "version" => "1.0.0",
                "contact" => [
                    "name" => "Spyrosoft Support",
                    "email" => "support@spyrosoft.com"
                ]
            ],
            "servers" => [
                [
                    "url" => $baseUrl . "rest/V1",
                    "description" => "Magento REST API Server"
                ]
            ],
            "security" => [
                [
                    "bearerAuth" => []
                ]
            ],
            "components" => [
                "securitySchemes" => [
                    "bearerAuth" => [
                        "type" => "http",
                        "scheme" => "bearer",
                        "bearerFormat" => "JWT"
                    ]
                ],
                "schemas" => [
                    "OrderStatus" => [
                        "type" => "object",
                        "properties" => [
                            "order_id" => ["type" => "string"],
                            "status" => ["type" => "string"],
                            "customer_email" => ["type" => "string"],
                            "total_amount" => ["type" => "number"],
                            "currency" => ["type" => "string"],
                            "created_at" => ["type" => "string"],
                            "updated_at" => ["type" => "string"]
                        ]
                    ],
                    "ProductInfo" => [
                        "type" => "object",
                        "properties" => [
                            "sku" => ["type" => "string"],
                            "name" => ["type" => "string"],
                            "price" => ["type" => "number"],
                            "currency" => ["type" => "string"],
                            "description" => ["type" => "string"],
                            "availability" => ["type" => "string"],
                            "stock_quantity" => ["type" => "integer"]
                        ]
                    ],
                    "ReturnPolicy" => [
                        "type" => "object",
                        "properties" => [
                            "policy_text" => ["type" => "string"],
                            "return_period_days" => ["type" => "integer"],
                            "last_updated" => ["type" => "string"]
                        ]
                    ]
                ]
            ],
            "paths" => [
                "/mcp/order-status/{email}/{orderId}" => [
                    "get" => [
                        "summary" => "Get order status by email and order ID",
                        "description" => "Retrieve order status information for a specific order",
                        "parameters" => [
                            [
                                "name" => "email",
                                "in" => "path",
                                "required" => true,
                                "schema" => ["type" => "string"],
                                "description" => "Customer email address"
                            ],
                            [
                                "name" => "orderId",
                                "in" => "path",
                                "required" => true,
                                "schema" => ["type" => "string"],
                                "description" => "Order ID"
                            ]
                        ],
                        "responses" => [
                            "200" => [
                                "description" => "Order status retrieved successfully",
                                "content" => [
                                    "application/json" => [
                                        "schema" => ["\$ref" => "#/components/schemas/OrderStatus"]
                                    ]
                                ]
                            ],
                            "404" => [
                                "description" => "Order not found"
                            ]
                        ]
                    ]
                ],
                "/mcp/product-info/{sku}" => [
                    "get" => [
                        "summary" => "Get product information by SKU",
                        "description" => "Retrieve detailed product information",
                        "parameters" => [
                            [
                                "name" => "sku",
                                "in" => "path",
                                "required" => true,
                                "schema" => ["type" => "string"],
                                "description" => "Product SKU"
                            ]
                        ],
                        "responses" => [
                            "200" => [
                                "description" => "Product information retrieved successfully",
                                "content" => [
                                    "application/json" => [
                                        "schema" => ["\$ref" => "#/components/schemas/ProductInfo"]
                                    ]
                                ]
                            ],
                            "404" => [
                                "description" => "Product not found"
                            ]
                        ]
                    ]
                ],
                "/mcp/return-policy" => [
                    "get" => [
                        "summary" => "Get return policy information",
                        "description" => "Retrieve store return policy details",
                        "responses" => [
                            "200" => [
                                "description" => "Return policy retrieved successfully",
                                "content" => [
                                    "application/json" => [
                                        "schema" => ["\$ref" => "#/components/schemas/ReturnPolicy"]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $result->setData($openApiSchema);
        $result->setHeader('Content-Type', 'application/json');
        $result->setHeader('Access-Control-Allow-Origin', '*');
        
        return $result;
    }
}

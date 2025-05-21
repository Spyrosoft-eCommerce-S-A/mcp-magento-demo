<?php
/**
 * OpenAPI Schema Controller for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Controller\Schema;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Store\Model\StoreManagerInterface;
use Spyrosoft\MCPChatBotv3\Helper\Data as Helper;

/**
 * Class OpenAPI
 */
class OpenAPI implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;
    
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    
    /**
     * @var Helper
     */
    private $helper;

    /**
     * OpenAPI constructor.
     *
     * @param JsonFactory $resultJsonFactory
     * @param StoreManagerInterface $storeManager
     * @param Helper $helper
     */
    public function __construct(
        JsonFactory $resultJsonFactory,
        StoreManagerInterface $storeManager,
        Helper $helper
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->storeManager = $storeManager;
        $this->helper = $helper;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $storeUrl = $this->storeManager->getStore()->getBaseUrl();
        $storeName = $this->storeManager->getStore()->getName();
        
        $schema = [
            'openapi' => '3.0.0',
            'info' => [
                'title' => $storeName . ' MCP API',
                'description' => 'API for interacting with ' . $storeName . ' via the Model Context Protocol',
                'version' => '1.0.0',
                'contact' => [
                    'email' => 'support@example.com'
                ]
            ],
            'servers' => [
                ['url' => $storeUrl, 'description' => 'Store API']
            ],
            'paths' => $this->getPaths(),
            'components' => [
                'schemas' => $this->getSchemas(),
                'securitySchemes' => $this->getSecuritySchemes()
            ]
        ];
        
        if ($this->helper->isAuthRequired()) {
            $schema['security'] = [['bearerAuth' => []]];
        }
        
        $result = $this->resultJsonFactory->create();
        $result->setData($schema);
        $result->setHeader('Content-Type', 'application/json');
        
        return $result;
    }
    
    /**
     * Get API paths
     *
     * @return array
     */
    private function getPaths(): array
    {
        return [
            '/rest/V1/mcp/order-status/{email}/{orderId}' => [
                'get' => [
                    'summary' => 'Get order status by email and order ID',
                    'description' => 'Returns order status data if the provided email and order ID match an existing order',
                    'operationId' => 'getOrderStatus',
                    'parameters' => [
                        [
                            'name' => 'email',
                            'in' => 'path',
                            'required' => true,
                            'description' => 'Customer email address',
                            'schema' => ['type' => 'string', 'format' => 'email']
                        ],
                        [
                            'name' => 'orderId',
                            'in' => 'path',
                            'required' => true,
                            'description' => 'Order ID',
                            'schema' => ['type' => 'string']
                        ]
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Successful operation',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/OrderStatus'
                                    ]
                                ]
                            ]
                        ],
                        '404' => [
                            'description' => 'Order not found or email does not match'
                        ]
                    ]
                ]
            ],
            '/rest/V1/mcp/product-info/{sku}' => [
                'get' => [
                    'summary' => 'Get product information by SKU',
                    'description' => 'Returns product metadata by SKU',
                    'operationId' => 'getProductInfo',
                    'parameters' => [
                        [
                            'name' => 'sku',
                            'in' => 'path',
                            'required' => true,
                            'description' => 'Product SKU',
                            'schema' => ['type' => 'string']
                        ]
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Successful operation',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/ProductInfo'
                                    ]
                                ]
                            ]
                        ],
                        '404' => [
                            'description' => 'Product not found'
                        ]
                    ]
                ]
            ],
            '/rest/V1/mcp/return-policy' => [
                'get' => [
                    'summary' => 'Get store return policy',
                    'description' => 'Returns the store\'s return policy text in plain text or Markdown',
                    'operationId' => 'getReturnPolicy',
                    'responses' => [
                        '200' => [
                            'description' => 'Successful operation',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/ReturnPolicy'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
    
    /**
     * Get API schemas
     *
     * @return array
     */
    private function getSchemas(): array
    {
        return [
            'OrderStatus' => [
                'type' => 'object',
                'properties' => [
                    'order_id' => ['type' => 'string'],
                    'status' => ['type' => 'string'],
                    'shipment_tracking' => ['type' => 'string'],
                    'total' => ['type' => 'number', 'format' => 'float'],
                    'currency' => ['type' => 'string'],
                    'created_at' => ['type' => 'string', 'format' => 'date-time'],
                    'items' => [
                        'type' => 'array',
                        'items' => [
                            'type' => 'object',
                            'properties' => [
                                'sku' => ['type' => 'string'],
                                'name' => ['type' => 'string'],
                                'qty' => ['type' => 'integer']
                            ]
                        ]
                    ]
                ]
            ],
            'ProductInfo' => [
                'type' => 'object',
                'properties' => [
                    'sku' => ['type' => 'string'],
                    'name' => ['type' => 'string'],
                    'price' => ['type' => 'number', 'format' => 'float'],
                    'currency' => ['type' => 'string'],
                    'stock_status' => ['type' => 'string', 'enum' => ['in_stock', 'out_of_stock']],
                    'short_description' => ['type' => 'string'],
                    'image_url' => ['type' => 'string', 'format' => 'uri'],
                    'category_ids' => [
                        'type' => 'array',
                        'items' => ['type' => 'integer']
                    ]
                ]
            ],
            'ReturnPolicy' => [
                'type' => 'object',
                'properties' => [
                    'policy_text' => ['type' => 'string']
                ]
            ]
        ];
    }
    
    /**
     * Get security schemes
     *
     * @return array
     */
    private function getSecuritySchemes(): array
    {
        if ($this->helper->isAuthRequired()) {
            return [
                'bearerAuth' => [
                    'type' => 'http',
                    'scheme' => 'bearer'
                ]
            ];
        }
        
        return [];
    }
}

<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Model;

use Spyrosoft\MCPChatBotv7\Api\OpenApiInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\UrlInterface;

class OpenApi implements OpenApiInterface
{
    private StoreManagerInterface $storeManager;
    private Json $jsonSerializer;

    public function __construct(
        StoreManagerInterface $storeManager,
        Json $jsonSerializer
    ) {
        $this->storeManager = $storeManager;
        $this->jsonSerializer = $jsonSerializer;
    }

    public function getOpenApiSpec(): string
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB);
        if (substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }
        $serverUrl = $baseUrl . 'rest/V1/mcp';

        $openApiData = [
            'openapi' => '3.0.0',
            'info' => [
                'title' => 'Magento Store MCP API',
                'version' => 'v1',
                'description' => 'API for managing Magento store orders and products.'
            ],
            'servers' => [
                [
                    'url' => $serverUrl
                ]
            ],
            'paths' => [
                '/order-status/{email}/{orderId}' => [
                    'get' => [
                        'summary' => 'Get Order Status',
                        'description' => 'Returns order status data if the provided email and order ID match an existing order.',
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
                                        'schema' => ['$ref' => '#/components/schemas/OrderStatus']
                                    ]
                                ]
                            ],
                            '404' => ['description' => 'Order not found']
                        ]
                    ]
                ],
                '/product-info/{sku}' => [
                    'get' => [
                        'summary' => 'Get Product Information',
                        'description' => 'Returns product metadata by SKU.',
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
                                        'schema' => ['$ref' => '#/components/schemas/ProductInfo']
                                    ]
                                ]
                            ],
                            '404' => ['description' => 'Product not found']
                        ]
                    ]
                ],
                '/return-policy' => [
                    'get' => [
                        'summary' => 'Get Return Policy',
                        'description' => 'Returns the store\'s return policy text.',
                        'operationId' => 'getReturnPolicy',
                        'responses' => [
                            '200' => [
                                'description' => 'Successful operation',
                                'content' => [
                                    'application/json' => [
                                        'schema' => ['$ref' => '#/components/schemas/ReturnPolicy']
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'components' => [
                'schemas' => [
                    'OrderStatus' => [
                        'type' => 'object',
                        'properties' => [
                            'order_id' => ['type' => 'string', 'example' => '100000123'],
                            'status' => ['type' => 'string', 'example' => 'complete'],
                            'shipment_tracking' => ['type' => 'string', 'example' => 'UPS123456'],
                            'total' => ['type' => 'number', 'format' => 'float', 'example' => 120.50],
                            'currency' => ['type' => 'string', 'example' => 'USD'],
                            'created_at' => ['type' => 'string', 'format' => 'date-time', 'example' => '2024-11-10T14:33:00Z'],
                            'items' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/OrderItem']]
                        ]
                    ],
                    'OrderItem' => [
                        'type' => 'object',
                        'properties' => [
                            'sku' => ['type' => 'string', 'example' => '24-MB01'],
                            'name' => ['type' => 'string', 'example' => 'Joust Duffle Bag'],
                            'qty' => ['type' => 'integer', 'example' => 1]
                        ]
                    ],
                    'ProductInfo' => [
                        'type' => 'object',
                        'properties' => [
                            'sku' => ['type' => 'string', 'example' => '24-MB01'],
                            'name' => ['type' => 'string', 'example' => 'Joust Duffle Bag'],
                            'price' => ['type' => 'number', 'format' => 'float', 'example' => 34.00],
                            'currency' => ['type' => 'string', 'example' => 'USD'],
                            'stock_status' => ['type' => 'string', 'example' => 'in_stock'],
                            'short_description' => ['type' => 'string', 'example' => 'Perfect for the gym or a weekend trip.'],
                            'image_url' => ['type' => 'string', 'format' => 'url', 'example' => 'https://store.example.com/media/catalog/product/j/o/joust_duffle_bag.jpg'],
                            'category_ids' => ['type' => 'array', 'items' => ['type' => 'integer'], 'example' => [3, 5]]
                        ]
                    ],
                    'ReturnPolicy' => [
                        'type' => 'object',
                        'properties' => [
                            'policy_text' => ['type' => 'string', 'example' => 'You may return items within 30 days of delivery. Please contact support for RMA instructions.']
                        ]
                    ]
                ]
            ]
        ];
        return $this->jsonSerializer->serialize($openApiData);
    }
}

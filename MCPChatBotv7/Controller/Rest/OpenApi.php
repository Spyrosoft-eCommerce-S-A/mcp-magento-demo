<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Controller\Rest;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class OpenApi implements HttpGetActionInterface
{
    private CONST RESPONSE_CODE_200 = 200;
    private CONST HEADER_CONTENT_TYPE = 'Content-Type';
    private CONST CONTENT_TYPE_JSON = 'application/json';
    private CONST URL = 'rest/V1/mcp';


    /**
     * @param JsonFactory $resultJsonFactory
     * @param RequestInterface $request
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private JsonFactory $resultJsonFactory,
        private RequestInterface $request,
        private StoreManagerInterface $storeManager
    ) {
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB);
        if (substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }

        $serverUrl = $baseUrl . self::URL;

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
                        'description' => '',
                        'operationId' => 'getOrderStatus',
                        'parameters' => [
                            [
                                'name' => 'email',
                                'in' => 'path',
                                'required' => true,
                                'description' => 'Customer email address',
                                'schema' => [
                                    'type' => 'string',
                                    'format' => 'email'
                                ]
                            ],
                            [
                                'name' => 'orderId',
                                'in' => 'path',
                                'required' => true,
                                'description' => 'Order ID',
                                'schema' => [
                                    'type' => 'string'
                                ]
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
                                'description' => 'Order not found'
                            ]
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
                                'schema' => [
                                    'type' => 'string'
                                ]
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
                                        'schema' => [
                                            '$ref' => '#/components/schemas/ReturnPolicy'
                                        ]
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
                            'items' => [
                                'type' => 'array',
                                'items' => ['$ref' => '#/components/schemas/OrderItem']
                            ]
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
                            'image_url' => ['type' => 'string', 'format' => 'url', 'example' => 'https://example.com/media/catalog/product/j/o/joust_duffle_bag.jpg'],
                            'category_ids' => [
                                'type' => 'array',
                                'items' => ['type' => 'integer'],
                                'example' => [3, 5]
                            ]
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

        $result = $this->resultJsonFactory->create();
        $result->setData($openApiData);
        $result->setHttpResponseCode(self::RESPONSE_CODE_200);
        $result->setHeader(self::HEADER_CONTENT_TYPE, self::CONTENT_TYPE_JSON, true);
        return $result;
    }
}

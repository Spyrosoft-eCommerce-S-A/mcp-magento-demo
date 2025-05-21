<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Enum;

use PhpParser\Node\Stmt\Return_;

/**
  * @package Spyrosoft\MCPChatBotv7\Enum
  */
enum ApiEnum
{
    public const SKU = 'sku';
    public const NAME = 'name';
    public const QTY = 'qty';
    public const ORDER_ID = 'order_id';
    public const STATUS = 'status';
    public const SHIPMENT_TRACKING = 'shipment_tracking';
    public const TOTAL = 'total';
    public const CURRENCY = 'currency';
    public const CREATED_AT = 'created_at';
    public const ITEMS = 'items';
    public const INCREMENT_ID = 'increment_id';

    public const PRICE = 'price';
    public const STOCK_STATUS = 'stock_status';
    public const SHORT_DESCRIPTION = 'short_description';
    public const IMAGE_URL = 'image_url';
    public const CATEGORY_IDS = 'category_ids';
    public const CUSTOMER_EMAIL = 'customer_email';

    public const FINAL_PRICE = 'final_price';
    public const IN_STOCK = 'in_stock';
    public const OUT_OF_STOCK = 'out_of_stock';

    public const POLICY_TEXT = 'policy_text';
    public const DEFAULT_POLICY = 'No return policy';
    public const RETURN_POLICY = 'return_policy';

}

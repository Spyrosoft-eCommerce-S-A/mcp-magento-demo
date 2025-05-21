Create a Magento 2 module named Spyrosoft_MCPChatBotvX that exposes REST endpoints compliant with the Model Context Protocol (MCP), enabling external chatbots to query Magento 2 store data. The module must provide a .well-known/ai-plugin.json manifest, an OpenAPI 3.0 schema at /openapi.json, and three REST API endpoints:

GET /rest/V1/mcp/order-status/:email/:orderId
Returns order status data if the provided email and order ID match an existing order.
Response format:

json
{
  "order_id": "100000123",
  "status": "complete",
  "shipment_tracking": "UPS123456",
  "total": 120.50,
  "currency": "USD",
  "created_at": "2024-11-10T14:33:00Z",
  "items": [
    {
      "sku": "24-MB01",
      "name": "Joust Duffle Bag",
      "qty": 1
    }
  ]
}
GET /rest/V1/mcp/product-info/:sku
Returns product metadata by SKU.
Response format:

json
{
  "sku": "24-MB01",
  "name": "Joust Duffle Bag",
  "price": 34.00,
  "currency": "USD",
  "stock_status": "in_stock",
  "short_description": "Perfect for the gym or a weekend trip.",
  "image_url": "https://store.example.com/media/catalog/product/j/o/joust_duffle_bag.jpg",
  "category_ids": [3, 5]
}

GET /rest/V1/mcp/return-policy
Returns the store's return policy text in plain text or Markdown.
Response format:

json
{
  "policy_text": "You may return items within 30 days of delivery. Please contact support for RMA instructions."
}
The module must:

Provide /.well-known/ai-plugin.json with MCP metadata.

Provide /openapi.json defining the endpoints and response schemas in OpenAPI 3.0.

Be installable under app/code/Vendor/MCPChatBot.

Use webapi.xml to define public endpoints.

Allow anonymous access to endpoints OR require a bearer token if configured.

Include basic admin configuration options:

Enable/disable the module.

Define and require a bearer token for access (optional).

Prevent exposing sensitive customer data. Orders should only be returned if both email and order ID match.

Be compatible with Magento 2.4.x Open Source and Adobe Commerce.

Follow PSR standards and Magento best practices.

Do not implement customer login or account modification. Do not add GraphQL support. Do not store logs or usage history. Keep it lightweight and API-focused.

Add a static file or controller for serving .well-known/ai-plugin.json. You may also serve openapi.json statically.

Optionally, provide a Postman collection for testing.
<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Model;

use Spyrosoft\MCPChatBot\Api\OrderStatusInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\Order;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class OrderStatus
 */
class OrderStatus implements OrderStatusInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var AuthValidator
     */
    private $authValidator;

    /**
     * OrderStatus constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param AuthValidator $authValidator
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ScopeConfigInterface $scopeConfig,
        AuthValidator $authValidator
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->authValidator = $authValidator;
    }

    /**
     * @inheritDoc
     */
    public function getOrderStatus($email, $orderId)
    {
        // Check if module is enabled
        if (!$this->isModuleEnabled()) {
            throw new LocalizedException(__('MCP ChatBot module is disabled.'));
        }

        // Validate authentication if required
        $this->authValidator->validate();

        // Find order by increment ID and customer email
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('increment_id', $orderId)
            ->addFilter('customer_email', $email)
            ->create();

        $orders = $this->orderRepository->getList($searchCriteria);

        if ($orders->getTotalCount() === 0) {
            throw new NoSuchEntityException(__('Order not found or email does not match.'));
        }

        /** @var Order $order */
        $order = $orders->getItems()[0];

        // Get order items
        $items = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $items[] = [
                'sku' => $item->getSku(),
                'name' => $item->getName(),
                'qty' => (int)$item->getQtyOrdered()
            ];
        }

        // Get shipment tracking
        $trackingNumber = '';
        foreach ($order->getShipmentsCollection() as $shipment) {
            foreach ($shipment->getAllTracks() as $track) {
                $trackingNumber = $track->getTrackNumber();
                break 2; // Get first tracking number
            }
        }

        return [
            'order_id' => $order->getIncrementId(),
            'status' => $order->getStatus(),
            'shipment_tracking' => $trackingNumber,
            'total' => (float)$order->getGrandTotal(),
            'currency' => $order->getOrderCurrencyCode(),
            'created_at' => $order->getCreatedAt(),
            'items' => $items
        ];
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    private function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'spyrosoft_mcpchatbot/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }
}

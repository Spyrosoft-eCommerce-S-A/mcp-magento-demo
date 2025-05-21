<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv4\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Spyrosoft\MCPChatBotv4\Api\OrderStatusServiceInterface;
use Spyrosoft\MCPChatBotv4\Api\Data\OrderStatusInterface;
use Spyrosoft\MCPChatBotv4\Api\Data\OrderStatusInterfaceFactory;
use Spyrosoft\MCPChatBotv4\Api\Data\OrderItemInterfaceFactory;

class OrderStatusService implements OrderStatusServiceInterface
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderStatusInterfaceFactory $orderStatusFactory,
        private OrderItemInterfaceFactory $orderItemFactory
    ) {}

    public function getOrderStatus(string $email, string $orderId): OrderStatusInterface
    {
        try {
            $order = $this->orderRepository->get($orderId);
            
            // Validate that the email matches the order
            if ($order->getCustomerEmail() !== $email) {
                throw new NoSuchEntityException(__('Order not found for the provided email.'));
            }

            $orderStatus = $this->orderStatusFactory->create();
            $orderStatus->setOrderId($order->getIncrementId());
            $orderStatus->setStatus($order->getStatus());
            $orderStatus->setTotal($order->getGrandTotal());
            $orderStatus->setCurrency($order->getOrderCurrencyCode());
            $orderStatus->setCreatedAt($order->getCreatedAt());

            // Get tracking info if available
            $tracks = [];
            foreach ($order->getShipmentsCollection() as $shipment) {
                foreach ($shipment->getAllTracks() as $track) {
                    $tracks[] = $track->getTrackNumber();
                }
            }
            $orderStatus->setShipmentTracking(!empty($tracks) ? implode(', ', $tracks) : null);

            // Get order items
            $items = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $orderItem = $this->orderItemFactory->create();
                $orderItem->setSku($item->getSku());
                $orderItem->setName($item->getName());
                $orderItem->setQty((int)$item->getQtyOrdered());
                $items[] = $orderItem;
            }
            $orderStatus->setItems($items);

            return $orderStatus;
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__('Order not found.'));
        }
    }
}

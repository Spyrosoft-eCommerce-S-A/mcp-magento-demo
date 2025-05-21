<?php
namespace Spyrosoft\MCPChatBot\Model;

use Spyrosoft\MCPChatBot\Api\OrderStatusInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use Magento\Sales\Api\OrderAddressRepositoryInterface;
use Magento\Sales\Model\Order\ShipmentRepository;
use Magento\Framework\Exception\NoSuchEntityException;

class OrderStatus implements OrderStatusInterface
{
    protected $orderRepository;
    protected $shipmentRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ShipmentRepository $shipmentRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->shipmentRepository = $shipmentRepository;
    }

    public function getOrderStatus($email, $orderId)
    {
        try {
            $order = $this->orderRepository->get($orderId);
            if (strtolower($order->getCustomerEmail()) !== strtolower($email)) {
                throw new NoSuchEntityException(__("Order not found for this email."));
            }
            $shipmentTracking = null;
            $shipments = $order->getShipmentsCollection();
            foreach ($shipments as $shipment) {
                foreach ($shipment->getAllTracks() as $track) {
                    $shipmentTracking = $track->getTrackNumber();
                    break 2;
                }
            }
            $items = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $items[] = [
                    'sku' => $item->getSku(),
                    'name' => $item->getName(),
                    'qty' => (int)$item->getQtyOrdered()
                ];
            }
            return [
                'order_id' => $order->getIncrementId(),
                'status' => $order->getStatus(),
                'shipment_tracking' => $shipmentTracking,
                'total' => (float)$order->getGrandTotal(),
                'currency' => $order->getOrderCurrencyCode(),
                'created_at' => $order->getCreatedAt(),
                'items' => $items
            ];
        } catch (NoSuchEntityException $e) {
            return ['error' => 'Order not found.'];
        }
    }
}

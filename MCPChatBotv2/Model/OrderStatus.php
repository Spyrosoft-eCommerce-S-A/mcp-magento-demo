<?php
namespace Spyrosoft\MCPChatBotv2\Model;

use Spyrosoft\MCPChatBotv2\Api\OrderStatusInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;

class OrderStatus implements OrderStatusInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderStatus($email, $orderId)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('increment_id', $orderId)
            ->addFilter('customer_email', $email)
            ->create();

        $orderList = $this->orderRepository->getList($searchCriteria);

        if ($orderList->getTotalCount() == 0) {
            throw new NoSuchEntityException(__('Order with ID "%1" and email "%2" not found.', $orderId, $email));
        }

        /** @var \Magento\Sales\Model\Order $order */
        $order = current($orderList->getItems());
        $items = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $items[] = [
                'sku' => $item->getSku(),
                'name' => $item->getName(),
                'qty' => $item->getQtyOrdered(),
            ];
        }

        return [
            [
                'order_id' => $order->getIncrementId(),
                'status' => $order->getStatus(),
                'shipment_tracking' => $this->_getTrackingNumber($order),
                'total' => $order->getGrandTotal(),
                'currency' => $order->getOrderCurrencyCode(),
                'created_at' => $order->getCreatedAt(),
                'items' => $items,
            ]
        ];
    }

    /**
     * Get tracking number from order
     *
     * @param \Magento\Sales\Model\Order $order
     * @return string|null
     */
    private function _getTrackingNumber(\Magento\Sales\Model\Order $order)
    {
        $trackingNumbers = [];
        $shipments = $order->getShipmentsCollection();
        foreach ($shipments as $shipment) {
            foreach ($shipment->getAllTracks() as $track) {
                $trackingNumbers[] = $track->getTrackNumber();
            }
        }
        return !empty($trackingNumbers) ? implode(', ', $trackingNumbers) : null;
    }
}

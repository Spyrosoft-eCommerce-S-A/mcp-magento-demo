<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv7\Model;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Spyrosoft\MCPChatBotv7\Api\OrderStatusRepositoryInterface;
use Spyrosoft\MCPChatBotv7\Api\Data\OrderStatusInterface;
use Spyrosoft\MCPChatBotv7\Api\Data\OrderStatusInterfaceFactory;
use Spyrosoft\MCPChatBotv7\Api\Data\OrderItemInterface;
use Spyrosoft\MCPChatBotv7\Enum\ApiEnum;
use Spyrosoft\MCPChatBotv7\Api\Data\OrderItemInterfaceFactory;
use Magento\Sales\Api\Data\OrderInterface;

class OrderStatusRepository implements OrderStatusRepositoryInterface
{
    private OrderRepositoryInterface $orderRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private OrderStatusInterfaceFactory $orderStatusFactory;
    private OrderItemInterfaceFactory $orderItemFactory;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderStatusInterfaceFactory $orderStatusFactory,
        OrderItemInterfaceFactory $orderItemFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->orderStatusFactory = $orderStatusFactory;
        $this->orderItemFactory = $orderItemFactory;
    }

    public function getOrderStatus(string $email, string $orderId): OrderStatusInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(ApiEnum::CUSTOMER_EMAIL, $email)
            ->addFilter(ApiEnum::INCREMENT_ID, $orderId)
            ->create();

        $orderList = $this->orderRepository->getList($searchCriteria)->getItems();

        if (empty($orderList)) {
            throw new NoSuchEntityException(__(
                'No order found for email "%1" and order ID "%2".',
                $email,
                $orderId
            ));
        }

        /** @var OrderInterface $order */
        $order = current($orderList);
        $orderStatus = $this->orderStatusFactory->create();
        $orderStatus->setOrderId($order->getIncrementId());
        $orderStatus->setStatus($order->getStatus());

        $shipmentTracking = null;
        $shipments = $order->getShipmentsCollection();
        if ($shipments && $shipments->getFirstItem()) {
            $tracks = $shipments->getFirstItem()->getTracksCollection();
            if ($tracks && $tracks->getFirstItem()) {
                $shipmentTracking = $tracks->getFirstItem()->getTrackNumber();
            }
        }
        $orderStatus->setShipmentTracking($shipmentTracking);

        $orderStatus->setTotal((float)$order->getGrandTotal());
        $orderStatus->setCurrency($order->getOrderCurrencyCode());
        $orderStatus->setCreatedAt($order->getCreatedAt());

        $items = [];
        foreach ($order->getItems() as $item) {
            if ($item->getParentItemId()) {
                continue;
            }
            $orderItem = $this->orderItemFactory->create();
            $orderItem->setSku($item->getSku());
            $orderItem->setName($item->getName());
            $orderItem->setQty((int)$item->getQtyOrdered());
            $items[] = $orderItem;
        }
        $orderStatus->setItems($items);

        return $orderStatus;
    }
}

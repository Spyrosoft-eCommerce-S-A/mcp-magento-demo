<?php
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv5\Model;

use Spyrosoft\MCPChatBotv5\Api\OrderStatusServiceInterface;
use Spyrosoft\MCPChatBotv5\Api\Data\OrderStatusInterface;
use Spyrosoft\MCPChatBotv5\Api\Data\OrderStatusInterfaceFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Exception\NoSuchEntityException;

class OrderStatusService implements OrderStatusServiceInterface
{
    public function __construct(
        private OrderStatusInterfaceFactory $orderStatusFactory,
        private OrderRepositoryInterface $orderRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private FilterBuilder $filterBuilder
    ) {}

    public function getOrderStatus(string $email, string $orderId): OrderStatusInterface
    {
        $filters = [
            $this->filterBuilder->setField('increment_id')->setValue($orderId)->create(),
            $this->filterBuilder->setField('customer_email')->setValue($email)->create()
        ];
        $criteria = $this->searchCriteriaBuilder->addFilters($filters)->create();
        $items = $this->orderRepository->getList($criteria)->getItems();
        if (empty($items)) {
            throw new NoSuchEntityException(__("Order '%1' for '%2' not found", $orderId, $email));
        }
        $order = array_shift($items);

        $status = $this->orderStatusFactory->create();
        $status->setOrderId($order->getIncrementId());
        $status->setStatus($order->getStatus());
        $status->setShipmentTracking($order->getTracks() ? $order->getTracks()[0]->getTrackNumber() : null);
        $status->setTotal((float)$order->getGrandTotal());
        $status->setCurrency((string)$order->getOrderCurrencyCode());
        $status->setCreatedAt($order->getCreatedAt());
        $itemsData = [];
        foreach ($order->getAllItems() as $item) {
            $itemsData[] = [
                'sku' => $item->getSku(),
                'name' => $item->getName(),
                'qty' => (int)$item->getQtyOrdered()
            ];
        }
        $status->setItems($itemsData);

        return $status;
    }
}

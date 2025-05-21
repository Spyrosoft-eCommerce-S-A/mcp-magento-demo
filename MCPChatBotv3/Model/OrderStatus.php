<?php
/**
 * OrderStatus Model for Spyrosoft_MCPChatBotv3
 *
 * @category  Spyrosoft
 * @package   Spyrosoft_MCPChatBotv3
 */
declare(strict_types=1);

namespace Spyrosoft\MCPChatBotv3\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\ShipmentTrackRepositoryInterface;
use Spyrosoft\MCPChatBotv3\Api\OrderStatusInterface;
use Spyrosoft\MCPChatBotv3\Helper\Data as Helper;
use Magento\Framework\Webapi\Rest\Request;

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
     * @var ShipmentTrackRepositoryInterface
     */
    private $trackRepository;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * OrderStatus constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ShipmentTrackRepositoryInterface $trackRepository
     * @param Helper $helper
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ShipmentTrackRepositoryInterface $trackRepository,
        Helper $helper
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->trackRepository = $trackRepository;
        $this->helper = $helper;
    }

    /**
     * Get order status by email and order ID
     *
     * @param string $email Customer email
     * @param string $orderId Order ID
     * @return array Order status data
     * @throws LocalizedException
     */
    public function getOrderStatus(string $email, string $orderId): array
    {
        // Validate module is enabled
        if (!$this->helper->isEnabled()) {
            throw new LocalizedException(__('MCP ChatBot module is disabled'));
        }

        try {
            $order = $this->getOrderByEmailAndId($email, $orderId);
        } catch (NoSuchEntityException $e) {
            return [
                'error' => 'Order not found or email does not match order',
                'status' => 404
            ];
        }

        // Get tracking info if available
        $trackingNumber = $this->getTrackingNumber($order);
        
        // Build response
        $response = [
            'order_id' => $order->getIncrementId(),
            'status' => $order->getStatus(),
            'shipment_tracking' => $trackingNumber,
            'total' => (float)$order->getGrandTotal(),
            'currency' => $order->getOrderCurrencyCode(),
            'created_at' => $order->getCreatedAt(),
            'items' => []
        ];
        
        // Add ordered items
        foreach ($order->getAllVisibleItems() as $item) {
            $response['items'][] = [
                'sku' => $item->getSku(),
                'name' => $item->getName(),
                'qty' => (int)$item->getQtyOrdered()
            ];
        }
        
        return $response;
    }
    
    /**
     * Get order by email and ID
     *
     * @param string $email
     * @param string $orderId
     * @return OrderInterface
     * @throws NoSuchEntityException
     */
    private function getOrderByEmailAndId(string $email, string $orderId): OrderInterface
    {
        // Create search criteria to find order
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(OrderInterface::INCREMENT_ID, $orderId)
            ->addFilter(OrderInterface::CUSTOMER_EMAIL, $email)
            ->create();
            
        $orders = $this->orderRepository->getList($searchCriteria)->getItems();
        
        // If no orders found or more than one order found (shouldn't happen)
        if (empty($orders)) {
            throw new NoSuchEntityException(__('Order not found with provided email and ID'));
        }
        
        return reset($orders);
    }
    
    /**
     * Get tracking number for order
     *
     * @param OrderInterface $order
     * @return string
     */
    private function getTrackingNumber(OrderInterface $order): string
    {
        $trackingNumber = '';
        
        // Get shipments for order
        $shipments = $order->getShipmentsCollection();
        if ($shipments && $shipments->getSize() > 0) {
            foreach ($shipments as $shipment) {
                $tracks = $shipment->getAllTracks();
                if (!empty($tracks)) {
                    $track = reset($tracks);
                    $trackingNumber = $track->getTrackNumber();
                    break; // Just get the first tracking number
                }
            }
        }
        
        return $trackingNumber;
    }
}

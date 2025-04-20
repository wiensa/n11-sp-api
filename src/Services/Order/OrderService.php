<?php

namespace N11Api\N11SpApi\Services\Order;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\N11Api;

class OrderService extends BaseService
{
    /**
     * OrderService constructor.
     * 
     * @param N11Api $api N11 API istemcisi
     */
    public function __construct(N11Api $api)
    {
        parent::__construct($api);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'OrderService';
    }
    
    /**
     * Siparişleri listeler.
     *
     * @param array $search_data Arama kriterleri
     * @return object
     */
    public function getOrders(array $search_data = []): object
    {
        $params = [];
        
        if (!empty($search_data)) {
            $params['searchData'] = $search_data;
        }
        
        return $this->callApi('OrderList', $params);
    }
    
    /**
     * Sipariş detayını getirir.
     *
     * @param int $order_id Sipariş ID
     * @return object
     */
    public function getOrderDetail(int $order_id): object
    {
        return $this->callApi('OrderDetail', [
            'orderRequest' => [
                'id' => $order_id
            ]
        ]);
    }
    
    /**
     * Siparişleri detaylı listeler.
     *
     * @param array $search_data Arama kriterleri
     * @return object
     */
    public function getDetailedOrders(array $search_data = []): object
    {
        $params = [];
        
        if (!empty($search_data)) {
            $params['searchData'] = $search_data;
        }
        
        return $this->callApi('DetailedOrderList', $params);
    }
    
    /**
     * Sipariş kalemini onaylar.
     *
     * @param array $order_item_list Sipariş kalemi listesi
     * @return object
     */
    public function acceptOrderItems(array $order_item_list): object
    {
        return $this->callApi('OrderItemAccept', [
            'orderItemList' => $order_item_list
        ]);
    }
    
    /**
     * Sipariş kalemini reddeder.
     *
     * @param array $order_item_list Sipariş kalemi listesi
     * @return object
     */
    public function rejectOrderItems(array $order_item_list): object
    {
        return $this->callApi('OrderItemReject', [
            'orderItemList' => $order_item_list
        ]);
    }
    
    /**
     * Sipariş kaleminin gönderim bilgisini günceller.
     *
     * @param array $shipment_info Gönderim bilgileri
     * @return object
     */
    public function shipOrderItem(array $shipment_info): object
    {
        return $this->callApi('MakeOrderItemShipment', [
            'orderItemShipmentList' => $shipment_info
        ]);
    }
    
    /**
     * Sipariş için takip numarasını günceller.
     *
     * @param array $tracking_info Takip bilgileri
     * @return object
     */
    public function updateTrackingNumber(array $tracking_info): object
    {
        return $this->callApi('UpdateTrackingNumber', [
            'orderItemShipmentList' => $tracking_info
        ]);
    }
} 
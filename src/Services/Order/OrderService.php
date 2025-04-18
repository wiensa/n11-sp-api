<?php

namespace N11Api\N11SpApi\Services\Order;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\Services\N11Client;

class OrderService extends BaseService
{
    /**
     * OrderService constructor.
     */
    public function __construct(N11Client $client)
    {
        parent::__construct($client);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'OrderService';
    }
    
    /**
     * Bu metot sipariş ile ilgili özet bilgileri listelemek için kullanılır.
     *
     * @param array $search_data Arama kriterleri
     * @return object
     */
    public function orderList(array $search_data = []): object
    {
        $params = [];
        
        if (!empty($search_data)) {
            $params['searchData'] = $search_data;
        }
        
        return $this->call('OrderList', $params);
    }
    
    /**
     * Sipariş N11 ID bilgisi kullanılarak sipariş detaylarını almak için kullanılır.
     *
     * @param int $order_id Sipariş ID
     * @return object
     */
    public function orderDetail(int $order_id): object
    {
        return $this->call('OrderDetail', [
            'orderRequest' => [
                'id' => $order_id
            ]
        ]);
    }
    
    /**
     * Bu metot sipariş kalemleri ile ilgili gelişmiş bilgileri listelemek için kullanılır.
     *
     * @param array $search_data Arama kriterleri
     * @return object
     */
    public function detailedOrderList(array $search_data = []): object
    {
        $params = [];
        
        if (!empty($search_data)) {
            $params['searchData'] = $search_data;
        }
        
        return $this->call('DetailedOrderList', $params);
    }
    
    /**
     * Bu metot sipariş kalemini onaylamak amacıyla kullanılır.
     *
     * @param array $order_item_list Sipariş kalemi listesi
     * @return object
     */
    public function orderItemAccept(array $order_item_list): object
    {
        return $this->call('OrderItemAccept', [
            'orderItemList' => $order_item_list
        ]);
    }
    
    /**
     * Bu metot sipariş kalemini reddetmek amacıyla kullanılır.
     *
     * @param array $order_item_list Sipariş kalemi listesi
     * @return object
     */
    public function orderItemReject(array $order_item_list): object
    {
        return $this->call('OrderItemReject', [
            'orderItemList' => $order_item_list
        ]);
    }
    
    /**
     * Bu metot sipariş kalemini kargolamak amacıyla kullanılır.
     *
     * @param array $order_item_list Sipariş kalemi listesi
     * @return object
     */
    public function makeOrderItemShipment(array $order_item_list): object
    {
        return $this->call('MakeOrderItemShipment', [
            'orderItemList' => $order_item_list
        ]);
    }
    
    /**
     * Bu metot sipariş kalemi için kargo kodunu değiştirmek amacıyla kullanılır.
     *
     * @param array $order_item_list Sipariş kalemi listesi
     * @return object
     */
    public function updateTrackingNumber(array $order_item_list): object
    {
        return $this->call('UpdateTrackingNumber', [
            'orderItemList' => $order_item_list
        ]);
    }
} 
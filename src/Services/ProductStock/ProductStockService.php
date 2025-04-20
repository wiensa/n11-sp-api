<?php

namespace N11Api\N11SpApi\Services\ProductStock;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\N11Api;

class ProductStockService extends BaseService
{
    /**
     * ProductStockService constructor.
     * 
     * @param N11Api $api N11 API istemcisi
     */
    public function __construct(N11Api $api)
    {
        parent::__construct($api);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ProductStockService';
    }
    
    /**
     * N11 ürün ID'si kullanılarak sistemdeki ürünün stoğunu sorgular.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function getProductStockByProductId(int $product_id): object
    {
        return $this->callApi('GetProductStockByProductId', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Mağaza ürün kodu kullanılarak sistemdeki ürünün stoğunu sorgular.
     *
     * @param string $seller_code Mağaza ürün kodu
     * @return object
     */
    public function getProductStockBySellerCode(string $seller_code): object
    {
        return $this->callApi('GetProductStockBySellerCode', [
            'sellerCode' => $seller_code
        ]);
    }
    
    /**
     * N11 ürün ID'si kullanılarak ürünün stoğunu günceller.
     *
     * @param array $params Güncelleme parametreleri
     * @return object
     */
    public function updateProductStock(array $params): object
    {
        return $this->callApi('UpdateProductStock', [
            'stockItems' => $params
        ]);
    }
    
    /**
     * Mağaza ürün kodu kullanılarak ürünün stoğunu günceller.
     *
     * @param array $params Güncelleme parametreleri
     * @return object
     */
    public function updateStockBySellerCode(array $params): object
    {
        return $this->callApi('UpdateStockByStockSellerCode', [
            'stockItems' => $params
        ]);
    }
} 
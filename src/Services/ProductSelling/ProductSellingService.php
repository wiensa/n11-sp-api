<?php

namespace N11Api\N11SpApi\Services\ProductSelling;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\N11Api;

class ProductSellingService extends BaseService
{
    /**
     * ProductSellingService constructor.
     * 
     * @param N11Api $api N11 API istemcisi
     */
    public function __construct(N11Api $api)
    {
        parent::__construct($api);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ProductSellingService';
    }
    
    /**
     * Satışta olan ürünün N11 ürün ID'si kullanılarak satışa kapatılması için kullanılır.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function stopSellingProductByProductId(int $product_id): object
    {
        return $this->callApi('StopSellingProductByProductId', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Satışta olmayan bir ürünün N11 ürün ID'si kullanılarak satışa başlanması için kullanılır.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function startSellingProductByProductId(int $product_id): object
    {
        return $this->callApi('StartSellingProductByProductId', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Satışta olan ürünün mağaza ürün kodu kullanılarak satışının durdurulması için kullanılır.
     *
     * @param string $seller_code Mağaza ürün kodu
     * @return object
     */
    public function stopSellingProductBySellerCode(string $seller_code): object
    {
        return $this->callApi('StopSellingProductBySellerCode', [
            'productSellerCode' => $seller_code
        ]);
    }
    
    /**
     * Satışta olmayan bir ürünün mağaza ürün kodu kullanılarak satışa başlanması için kullanılır.
     *
     * @param string $seller_code Mağaza ürün kodu
     * @return object
     */
    public function startSellingProductBySellerCode(string $seller_code): object
    {
        return $this->callApi('StartSellingProductBySellerCode', [
            'productSellerCode' => $seller_code
        ]);
    }
} 
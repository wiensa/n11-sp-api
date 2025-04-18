<?php

namespace N11Api\N11SpApi\Services\ProductStock;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\Services\N11Client;

class ProductStockService extends BaseService
{
    /**
     * ProductStockService constructor.
     */
    public function __construct(N11Client $client)
    {
        parent::__construct($client);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ProductStockService';
    }
    
    /**
     * Sistemde kayıtlı olan ürünün N11 ürün ID'si ile ürün stok bilgilerini getiren metottur.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function getProductStockByProductId(int $product_id): object
    {
        return $this->call('GetProductStockByProductId', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Sistemde kayıtlı olan ürünün mağaza ürün kodu ile ürün stok bilgilerini getiren metottur.
     *
     * @param string $seller_code Mağaza ürün kodu
     * @return object
     */
    public function getProductStockBySellerCode(string $seller_code): object
    {
        return $this->call('GetProductStockBySellerCode', [
            'sellerCode' => $seller_code
        ]);
    }
    
    /**
     * Bu metot ürün stoğunu güncellemek için kullanılır.
     *
     * @param array $product_stock Ürün stok bilgileri
     * @return object
     */
    public function updateProductStock(array $product_stock): object
    {
        return $this->call('UpdateProductStock', [
            'productStock' => $product_stock
        ]);
    }
    
    /**
     * Bu metot ürün stoğunu toplu olarak güncellemek için kullanılır.
     *
     * @param array $product_stocks Ürün stok bilgileri listesi
     * @return object
     */
    public function updateStockByStockSellerCode(array $product_stocks): object
    {
        return $this->call('UpdateStockByStockSellerCode', [
            'stockItems' => [
                'stockItem' => $product_stocks
            ]
        ]);
    }
} 
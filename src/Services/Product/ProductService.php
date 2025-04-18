<?php

namespace N11Api\N11SpApi\Services\Product;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\Services\N11Client;

class ProductService extends BaseService
{
    /**
     * ProductService constructor.
     */
    public function __construct(N11Client $client)
    {
        parent::__construct($client);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ProductService';
    }
    
    /**
     * N11 ürün ID'sini kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function getProductByProductId(int $product_id): object
    {
        return $this->call('GetProductByProductId', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Mağaza ürün kodunu kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
     *
     * @param string $seller_code Mağaza ürün kodu
     * @return object
     */
    public function getProductBySellerCode(string $seller_code): object
    {
        return $this->call('GetProductBySellerCode', [
            'sellerCode' => $seller_code
        ]);
    }
    
    /**
     * N11 üzerindeki ürünleri listelemek için kullanılır.
     *
     * @param array $paging_data Sayfalama bilgileri (opsiyonel)
     * @return object
     */
    public function getProductList(array $paging_data = []): object
    {
        $params = [];
        
        if (!empty($paging_data)) {
            $params['pagingData'] = $paging_data;
        }
        
        return $this->call('GetProductList', $params);
    }
    
    /**
     * Mağazaya yeni ürün eklemek için kullanılır.
     *
     * @param array $product Ürün bilgileri
     * @return object
     */
    public function saveProduct(array $product): object
    {
        return $this->call('SaveProduct', [
            'product' => $product
        ]);
    }
    
    /**
     * Kayıtlı olan bir ürünü N11 Id'si kullanarak silmek için kullanılır.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function deleteProductById(int $product_id): object
    {
        return $this->call('DeleteProductById', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Kayıtlı olan bir ürünü mağaza ürün kodu kullanılarak silmek için kullanılır.
     *
     * @param string $seller_code Mağaza ürün kodu
     * @return object
     */
    public function deleteProductBySellerCode(string $seller_code): object
    {
        return $this->call('DeleteProductBySellerCode', [
            'productSellerCode' => $seller_code
        ]);
    }
    
    /**
     * Bu metot mağazadaki ürünleri toplu şekilde onaylatmak için kullanılır.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function approveProducts(int $product_id): object
    {
        return $this->call('ApproveProducts', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Birden fazla ürünü silmek için kullanılır.
     *
     * @param array $product_ids Ürün ID listesi
     * @return object
     */
    public function batchDeleteProducts(array $product_ids): object
    {
        return $this->call('BatchDeleteProducts', [
            'productIdList' => [
                'productId' => $product_ids
            ]
        ]);
    }
    
    /**
     * Birden fazla ürünü kodlarıyla silmek için kullanılır.
     *
     * @param array $seller_codes Mağaza ürün kodları listesi
     * @return object
     */
    public function batchDeleteProductsBySellerCode(array $seller_codes): object
    {
        return $this->call('BatchDeleteProductsBySellerCode', [
            'productSellerCodeList' => [
                'productSellerCode' => $seller_codes
            ]
        ]);
    }
    
    /**
     * Ürünleri sayfalama bilgisi vererek ID listesi halinde getirir.
     *
     * @param array $paging_data Sayfalama bilgileri
     * @return object
     */
    public function getProductIdList(array $paging_data): object
    {
        return $this->call('GetProductIdList', [
            'pagingData' => $paging_data
        ]);
    }
} 
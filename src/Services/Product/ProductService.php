<?php

namespace N11Api\N11SpApi\Services\Product;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\N11Api;

class ProductService extends BaseService
{
    /**
     * ProductService constructor.
     * 
     * @param N11Api $api N11 API istemcisi
     */
    public function __construct(N11Api $api)
    {
        parent::__construct($api);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ProductService';
    }
    
    /**
     * N11 ürün ID'sini kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function getProductById(int $product_id): object
    {
        return $this->callApi('GetProductByProductId', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Mağaza ürün kodunu kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
     *
     * @param string $seller_code Mağaza ürün kodu
     * @return object
     */
    public function getProductByCode(string $seller_code): object
    {
        return $this->callApi('GetProductBySellerCode', [
            'sellerCode' => $seller_code
        ]);
    }
    
    /**
     * Ürünleri listeler.
     *
     * @param array $paging_data Sayfalama bilgileri (opsiyonel)
     * @return object
     */
    public function getProducts(array $paging_data = []): object
    {
        $params = [];
        
        if (!empty($paging_data)) {
            $params['pagingData'] = $paging_data;
        }
        
        return $this->callApi('GetProductList', $params);
    }
    
    /**
     * Mağazaya yeni ürün ekler.
     *
     * @param array $product Ürün bilgileri
     * @return object
     */
    public function createProduct(array $product): object
    {
        return $this->callApi('SaveProduct', [
            'product' => $product
        ]);
    }
    
    /**
     * N11 ürün ID'sini kullanarak sistemde kayıtlı olan bir ürünün silinmesi için kullanılır.
     *
     * @param int $product_id Ürün ID
     * @return object
     */
    public function deleteProductById(int $product_id): object
    {
        return $this->callApi('DeleteProductById', [
            'productId' => $product_id
        ]);
    }
    
    /**
     * Mağaza ürün kodunu kullanarak sistemde kayıtlı olan bir ürünün silinmesi için kullanılır.
     *
     * @param string $seller_code Mağaza ürün kodu
     * @return object
     */
    public function deleteProductBySellerCode(string $seller_code): object
    {
        return $this->callApi('DeleteProductBySellerCode', [
            'productSellerCode' => $seller_code
        ]);
    }
    
    /**
     * İşlem yapılan ve satın alınmayan ürünlerin onaylanması için kullanılır.
     *
     * @param array $products Ürün ID listesi
     * @return object
     */
    public function approveProducts(array $products): object
    {
        return $this->callApi('ApproveProducts', [
            'productIdList' => $products
        ]);
    }
    
    /**
     * N11 ürün ID'leri kullanılarak birden fazla ürünün silinmesi için kullanılır.
     *
     * @param array $products Ürün ID listesi
     * @return object
     */
    public function batchDeleteProducts(array $products): object
    {
        return $this->callApi('BatchDeleteProducts', [
            'productIdList' => $products
        ]);
    }
    
    /**
     * Mağaza ürün kodları kullanılarak birden fazla ürünün silinmesi için kullanılır.
     *
     * @param array $products Mağaza ürün kodları listesi
     * @return object
     */
    public function batchDeleteProductsBySellerCode(array $products): object
    {
        return $this->callApi('BatchDeleteProductsBySellerCode', [
            'productSellerCodeList' => $products
        ]);
    }
    
    /**
     * Arama kriterlerine göre ürün ID'lerini listeler.
     *
     * @param array $search_data Arama kriterleri
     * @return object
     */
    public function getProductIds(array $search_data): object
    {
        return $this->callApi('GetProductIdList', [
            'searchData' => $search_data
        ]);
    }
} 
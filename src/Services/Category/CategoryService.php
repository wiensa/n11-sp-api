<?php

namespace N11Api\N11SpApi\Services\Category;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\N11Api;
use N11Api\N11SpApi\Exceptions\N11ApiException;

class CategoryService extends BaseService
{
    /**
     * CategoryService constructor.
     * 
     * @param N11Api $api N11 API istemcisi
     */
    public function __construct(N11Api $api)
    {
        parent::__construct($api);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'CategoryService';
    }
    
    /**
     * N11 üzerinde tanımlanmış tüm üst seviye kategorileri döndürür.
     *
     * @return array
     * @throws N11ApiException
     */
    public function getCategories(): array
    {
        $response = $this->callApi('GetTopLevelCategories');
        return $this->formatCollectionResponse($response, 'categoryList');
    }
    
    /**
     * Kodu verilen kategorinin birinci seviye alt kategorilerine ulaşmak için kullanılır.
     *
     * @param int $category_id Kategori ID
     * @return array
     * @throws N11ApiException
     */
    public function getSubCategories(int $category_id): array
    {
        $response = $this->callApi('GetSubCategories', [
            'categoryId' => $category_id
        ]);
        
        return $this->formatCollectionResponse($response, 'category');
    }
    
    /**
     * Kodu verilen kategorinin birinci seviye üst kategorilerine ulaşmak için kullanılır.
     *
     * @param int $category_id Kategori ID
     * @return array
     * @throws N11ApiException
     */
    public function getParentCategory(int $category_id): array
    {
        $response = $this->callApi('GetParentCategory', [
            'categoryId' => $category_id
        ]);
        
        return $this->formatSingleResponse($response, 'category');
    }
    
    /**
     * İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, 
     * bu kategorilere ait olan özelliklerin listelenmesi için kullanılır.
     *
     * @param int $category_id Kategori ID
     * @return array
     * @throws N11ApiException
     */
    public function getCategoryAttributesId(int $category_id): array
    {
        $response = $this->callApi('GetCategoryAttributesId', [
            'categoryId' => $category_id
        ]);
        
        return $this->formatCollectionResponse($response, 'categoryAttribute');
    }
    
    /**
     * İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, 
     * bu kategorilere ait olan özelliklerin ve bu özelliklere ait değerlerin listelenmesi için kullanılır.
     *
     * @param int $category_id Kategori ID
     * @param array $paging_data Sayfalama bilgileri (opsiyonel)
     * @return array
     * @throws N11ApiException
     */
    public function getCategoryAttributes(int $category_id, array $paging_data = []): array
    {
        $params = [
            'categoryId' => $category_id
        ];
        
        if (!empty($paging_data)) {
            $params['pagingData'] = $paging_data;
        }
        
        $response = $this->callApi('GetCategoryAttributes', $params);
        
        return $this->formatCollectionResponse($response, 'categoryAttributes');
    }
    
    /**
     * Özelliğe sistemimizde verilen id bilgisini girdi vererek, o özelliğe ait değerleri listeler.
     *
     * @param int $attribute_id Özellik ID
     * @param array $paging_data Sayfalama bilgileri (opsiyonel)
     * @return array
     * @throws N11ApiException
     */
    public function getAttributeValues(int $attribute_id, array $paging_data = []): array
    {
        $params = [
            'categoryProductAttributeId' => $attribute_id
        ];
        
        if (!empty($paging_data)) {
            $params['pagingData'] = $paging_data;
        }
        
        $response = $this->callApi('GetCategoryAttributeValue', $params);
        
        return $this->formatCollectionResponse($response, 'categoryAttributeValue');
    }
} 
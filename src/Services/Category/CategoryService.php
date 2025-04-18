<?php

namespace N11Api\N11SpApi\Services\Category;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\Services\N11Client;

class CategoryService extends BaseService
{
    /**
     * CategoryService constructor.
     */
    public function __construct(N11Client $client)
    {
        parent::__construct($client);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'CategoryService';
    }
    
    /**
     * N11 üzerinde tanımlanmış tüm üst seviye kategorileri döndürür.
     *
     * @return object
     */
    public function getTopLevelCategories(): object
    {
        return $this->call('GetTopLevelCategories');
    }
    
    /**
     * Kodu verilen kategorinin birinci seviye alt kategorilerine ulaşmak için kullanılır.
     *
     * @param int $category_id Kategori ID
     * @return object
     */
    public function getSubCategories(int $category_id): object
    {
        return $this->call('GetSubCategories', [
            'categoryId' => $category_id
        ]);
    }
    
    /**
     * Kodu verilen kategorinin birinci seviye üst kategorilerine ulaşmak için kullanılır.
     *
     * @param int $category_id Kategori ID
     * @return object
     */
    public function getParentCategory(int $category_id): object
    {
        return $this->call('GetParentCategory', [
            'categoryId' => $category_id
        ]);
    }
    
    /**
     * İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, 
     * bu kategorilere ait olan özelliklerin listelenmesi için kullanılır.
     *
     * @param int $category_id Kategori ID
     * @return object
     */
    public function getCategoryAttributesId(int $category_id): object
    {
        return $this->call('GetCategoryAttributesId', [
            'categoryId' => $category_id
        ]);
    }
    
    /**
     * İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, 
     * bu kategorilere ait olan özelliklerin ve bu özelliklere ait değerlerin listelenmesi için kullanılır.
     *
     * @param int $category_id Kategori ID
     * @param array $paging_data Sayfalama bilgileri (opsiyonel)
     * @return object
     */
    public function getCategoryAttributes(int $category_id, array $paging_data = []): object
    {
        $params = [
            'categoryId' => $category_id
        ];
        
        if (!empty($paging_data)) {
            $params['pagingData'] = $paging_data;
        }
        
        return $this->call('GetCategoryAttributes', $params);
    }
    
    /**
     * Özelliğe sistemimizde verilen id bilgisini girdi vererek, o özelliğe ait değerleri listeler.
     *
     * @param int $attribute_id Özellik ID
     * @param array $paging_data Sayfalama bilgileri (opsiyonel)
     * @return object
     */
    public function getCategoryAttributeValue(int $attribute_id, array $paging_data = []): object
    {
        $params = [
            'categoryProductAttributeId' => $attribute_id
        ];
        
        if (!empty($paging_data)) {
            $params['pagingData'] = $paging_data;
        }
        
        return $this->call('GetCategoryAttributeValue', $params);
    }
} 
<?php

namespace N11Api\N11SpApi\Services\City;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\Services\N11Client;

class CityService extends BaseService
{
    /**
     * CityService constructor.
     */
    public function __construct(N11Client $client)
    {
        parent::__construct($client);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'CityService';
    }
    
    /**
     * N11 üzerindeki bütün şehirlerin listesini döndürür.
     *
     * @return object
     */
    public function getCities(): object
    {
        return $this->call('GetCities');
    }
    
    /**
     * Şehir hakkında detaylı bilgi döndürür.
     *
     * @param int $city_id Şehir ID
     * @return object
     */
    public function getCity(int $city_id): object
    {
        return $this->call('GetCity', [
            'cityCode' => $city_id
        ]);
    }
    
    /**
     * Plaka kodu verilen şehre ait ilçelerinin listelenmesi için kullanılır.
     *
     * @param int $city_id Şehir ID
     * @return object
     */
    public function getDistrict(int $city_id): object
    {
        return $this->call('GetDistrict', [
            'cityCode' => $city_id
        ]);
    }
    
    /**
     * İlçe kodu verilen semt/mahallelerin listelenmesi için kullanılır.
     *
     * @param int $district_id İlçe ID
     * @return object
     */
    public function getNeighborhoods(int $district_id): object
    {
        return $this->call('GetNeighborhoods', [
            'districtId' => $district_id
        ]);
    }
} 
<?php

namespace N11Api\N11SpApi\Services;

use N11Api\N11SpApi\N11Api;
use N11Api\N11SpApi\Traits\ApiRequest;
use N11Api\N11SpApi\Traits\ResponseFormatter;

abstract class BaseService
{
    use ApiRequest, ResponseFormatter;
    
    /**
     * N11 API istemcisi
     */
    protected N11Api $api;
    
    /**
     * Servis adı
     */
    protected string $service_name;
    
    /**
     * BaseService constructor.
     * 
     * @param N11Api $api N11 API istemcisi
     */
    public function __construct(N11Api $api)
    {
        $this->api = $api;
        
        // Çocuk sınıflar tarafından override edilebilir
        $this->service_name = $this->getServiceName();
    }
    
    /**
     * Servis adını sınıf adından otomatik olarak tespit eder
     * 
     * @return string Servis adı
     */
    protected function getServiceName(): string
    {
        $class_name = class_basename($this);
        
        // "Service" sonekini kaldır
        if (str_ends_with($class_name, 'Service')) {
            $class_name = substr($class_name, 0, -7);
        }
        
        return $class_name;
    }

    /**
     * SOAP metodu çağır
     * 
     * @param string $method Metot adı
     * @param array $params Parametreler
     * @param bool $use_cache Önbellek kullanılsın mı?
     * @return object Yanıt
     */
    protected function callApi(string $method, array $params = [], bool $use_cache = true): object
    {
        return $this->api->callSoapMethod($this->service_name, $method, $params, $use_cache);
    }
} 
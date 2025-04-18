<?php

namespace N11Api\N11SpApi\Services;

abstract class BaseService
{
    /**
     * N11 API istemcisi
     */
    protected N11Client $client;
    
    /**
     * Servis adı
     */
    protected string $service_name;
    
    /**
     * BaseService constructor.
     */
    public function __construct(N11Client $client)
    {
        $this->client = $client;
        
        // Çocuk sınıflar tarafından override edilebilir
        $this->service_name = $this->getServiceName();
    }
    
    /**
     * Servis adını sınıf adından otomatik olarak tespit eder
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
     */
    protected function call(string $method, array $params = []): object
    {
        return $this->client->callSoapMethod($this->service_name, $method, $params);
    }
} 
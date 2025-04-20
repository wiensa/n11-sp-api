<?php

namespace N11Api\N11SpApi;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use N11Api\N11SpApi\Services\Category\CategoryService;
use N11Api\N11SpApi\Services\City\CityService;
use N11Api\N11SpApi\Services\Order\OrderService;
use N11Api\N11SpApi\Services\Product\ProductService;
use N11Api\N11SpApi\Services\ProductSelling\ProductSellingService;
use N11Api\N11SpApi\Services\ProductStock\ProductStockService;
use N11Api\N11SpApi\Services\Shipment\ShipmentService;
use N11Api\N11SpApi\Services\ShipmentCompany\ShipmentCompanyService;
use N11Api\N11SpApi\Traits\ApiRequest;
use SoapClient;
use SoapFault;

class N11Api
{
    use ApiRequest;
    
    /**
     * N11 API anahtarı
     */
    protected string $app_key;

    /**
     * N11 API gizli anahtarı
     */
    protected string $app_secret;

    /**
     * N11 API baz URL'i
     */
    protected string $base_url;
    
    /**
     * N11 API istek zaman aşımı
     */
    protected int $timeout;
    
    /**
     * N11 API debug modu
     */
    protected bool $debug;
    
    /**
     * N11 API yetkilendirme parametreleri
     */
    protected array $auth_params;
    
    /**
     * Servis örnekleri
     */
    protected array $services = [];

    /**
     * N11Api constructor.
     * 
     * @param string|null $app_key API anahtarı
     * @param string|null $app_secret API gizli anahtarı
     * @param string|null $base_url API baz URL'i
     */
    public function __construct(string $app_key = null, string $app_secret = null, string $base_url = null)
    {
        $this->app_key = $app_key ?? config('n11-sp-api.app_key');
        $this->app_secret = $app_secret ?? config('n11-sp-api.app_secret');
        $this->base_url = $base_url ?? config('n11-sp-api.base_url');
        $this->timeout = config('n11-sp-api.timeout', 30);
        $this->debug = config('n11-sp-api.debug', false);
        
        $this->auth_params = [
            'auth' => [
                'appKey' => $this->app_key,
                'appSecret' => $this->app_secret
            ]
        ];
        
        if (empty($this->app_key) || empty($this->app_secret)) {
            throw new Exception('N11 API anahtarları tanımlanmamış. Lütfen .env dosyasında N11_APP_KEY ve N11_APP_SECRET değişkenlerini tanımlayın.');
        }
    }
    
    /**
     * SOAP istemcisi oluştur
     * 
     * @param string $service Servis adı
     * @return SoapClient
     * @throws SoapFault
     */
    public function createSoapClient(string $service): SoapClient
    {
        $wsdl = $this->base_url . $service . '.wsdl';
        
        try {
            $options = [
                'trace' => $this->debug,
                'exceptions' => true,
                'encoding' => 'UTF-8',
                'soap_version' => SOAP_1_1,
                'connection_timeout' => $this->timeout,
                'cache_wsdl' => WSDL_CACHE_MEMORY,
            ];
            
            return new SoapClient($wsdl, $options);
        } catch (SoapFault $e) {
            if ($this->debug) {
                Log::error('N11 SOAP Client Error', [
                    'service' => $service,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ]);
            }
            
            throw $e;
        }
    }
    
    /**
     * SOAP API'ye istek gönder
     * 
     * @param string $service Servis adı
     * @param string $method Metot adı
     * @param array $params Parametreler
     * @param bool $use_cache Önbellek kullanılsın mı?
     * @return object SOAP yanıtı
     */
    public function callSoapMethod(string $service, string $method, array $params = [], bool $use_cache = true): object
    {
        $client = $this->createSoapClient($service);
        $request_params = array_merge($this->auth_params, $params);
        
        if ($this->debug) {
            Log::debug('N11 API Request', [
                'service' => $service,
                'method' => $method,
                'params' => $request_params
            ]);
        }
        
        $cache_enabled = config('n11-sp-api.cache.enabled', true) && $use_cache;
        $cache_ttl = config('n11-sp-api.cache.ttl', 3600);
        
        // GET isteklerini önbelleğe alabiliriz
        $is_get_method = strpos(strtolower($method), 'get') === 0;
        
        if ($cache_enabled && $is_get_method) {
            $cache_key = 'n11-sp-api:' . $service . ':' . $method . ':' . md5(serialize($request_params));
            
            return Cache::remember($cache_key, $cache_ttl, function () use ($client, $method, $request_params) {
                return $client->{$method}($request_params);
            });
        }
        
        return $client->{$method}($request_params);
    }
    
    /**
     * Kategori servisi
     * 
     * @return CategoryService
     */
    public function categories(): CategoryService
    {
        if (!isset($this->services['category'])) {
            $this->services['category'] = new CategoryService($this);
        }
        
        return $this->services['category'];
    }
    
    /**
     * Şehir servisi
     * 
     * @return CityService
     */
    public function cities(): CityService
    {
        if (!isset($this->services['city'])) {
            $this->services['city'] = new CityService($this);
        }
        
        return $this->services['city'];
    }
    
    /**
     * Sipariş servisi
     * 
     * @return OrderService
     */
    public function orders(): OrderService
    {
        if (!isset($this->services['order'])) {
            $this->services['order'] = new OrderService($this);
        }
        
        return $this->services['order'];
    }
    
    /**
     * Ürün servisi
     * 
     * @return ProductService
     */
    public function products(): ProductService
    {
        if (!isset($this->services['product'])) {
            $this->services['product'] = new ProductService($this);
        }
        
        return $this->services['product'];
    }
    
    /**
     * Kargo servisi
     * 
     * @return ShipmentService
     */
    public function shipments(): ShipmentService
    {
        if (!isset($this->services['shipment'])) {
            $this->services['shipment'] = new ShipmentService($this);
        }
        
        return $this->services['shipment'];
    }
    
    /**
     * Kargo firması servisi
     * 
     * @return ShipmentCompanyService
     */
    public function shipmentCompanies(): ShipmentCompanyService
    {
        if (!isset($this->services['shipment_company'])) {
            $this->services['shipment_company'] = new ShipmentCompanyService($this);
        }
        
        return $this->services['shipment_company'];
    }
    
    /**
     * Ürün satış servisi
     * 
     * @return ProductSellingService
     */
    public function productSellings(): ProductSellingService
    {
        if (!isset($this->services['product_selling'])) {
            $this->services['product_selling'] = new ProductSellingService($this);
        }
        
        return $this->services['product_selling'];
    }
    
    /**
     * Ürün stok servisi
     * 
     * @return ProductStockService
     */
    public function productStocks(): ProductStockService
    {
        if (!isset($this->services['product_stock'])) {
            $this->services['product_stock'] = new ProductStockService($this);
        }
        
        return $this->services['product_stock'];
    }
    
    /**
     * API anahtarı alır
     * 
     * @return string
     */
    public function getAppKey(): string
    {
        return $this->app_key;
    }
    
    /**
     * API gizli anahtarı alır
     * 
     * @return string
     */
    public function getAppSecret(): string
    {
        return $this->app_secret;
    }
    
    /**
     * API baz URL'ini alır
     * 
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->base_url;
    }
} 
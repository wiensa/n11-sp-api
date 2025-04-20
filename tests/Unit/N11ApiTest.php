<?php

namespace N11Api\N11SpApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use N11Api\N11SpApi\Services\Category\CategoryService;
use N11Api\N11SpApi\Services\City\CityService;
use N11Api\N11SpApi\N11Api;
use N11Api\N11SpApi\Services\Order\OrderService;
use N11Api\N11SpApi\Services\Product\ProductService;
use N11Api\N11SpApi\Services\ProductSelling\ProductSellingService;
use N11Api\N11SpApi\Services\ProductStock\ProductStockService;
use N11Api\N11SpApi\Services\Shipment\ShipmentService;
use N11Api\N11SpApi\Services\ShipmentCompany\ShipmentCompanyService;
use SoapClient;
use stdClass;

/**
 * Test sınıfımızı oluşturup config() bağımlılığını aşırı yükleyerek (override) sorundan kurtuluyoruz
 */
class TestableN11Api extends N11Api
{
    public function __construct(string $app_key, string $app_secret, string $base_url)
    {
        $this->app_key = $app_key;
        $this->app_secret = $app_secret;
        $this->base_url = $base_url;
        $this->timeout = 30;
        $this->debug = false;
        
        $this->auth_params = [
            'auth' => [
                'appKey' => $this->app_key,
                'appSecret' => $this->app_secret
            ]
        ];
    }
    
    public function createSoapClient(string $service): SoapClient
    {
        // Testler için SoapClient'ı mock'layarak gerçek HTTP istekleri yapmamayı sağlıyoruz
        $mock = $this->getMockBuilder(SoapClient::class)
                     ->disableOriginalConstructor()
                     ->getMock();
        
        $mock->method('__call')
             ->willReturn(new stdClass());
        
        return $mock;
    }
}

class N11ApiTest extends TestCase
{
    protected TestableN11Api $client;
    
    /** @var string */
    private $app_key = 'test-app-key';
    
    /** @var string */
    private $app_secret = 'test-app-secret';
    
    /** @var string */
    private $base_url = 'https://api.n11.com/ws/';

    protected function setUp(): void
    {
        parent::setUp();

        // Test için TestableN11Api kullanıyoruz (config() bağımlılığını önlemek için)
        $this->client = new TestableN11Api(
            $this->app_key,
            $this->app_secret,
            $this->base_url
        );
    }

    /**
     * @test
     */
    public function it_returns_category_service(): void
    {
        $service = $this->client->categories();
        $this->assertInstanceOf(CategoryService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_city_service(): void
    {
        $service = $this->client->cities();
        $this->assertInstanceOf(CityService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_order_service(): void
    {
        $service = $this->client->orders();
        $this->assertInstanceOf(OrderService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_product_service(): void
    {
        $service = $this->client->products();
        $this->assertInstanceOf(ProductService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_shipment_service(): void
    {
        $service = $this->client->shipments();
        $this->assertInstanceOf(ShipmentService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_shipment_company_service(): void
    {
        $service = $this->client->shipmentCompanies();
        $this->assertInstanceOf(ShipmentCompanyService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_product_selling_service(): void
    {
        $service = $this->client->productSellings();
        $this->assertInstanceOf(ProductSellingService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_product_stock_service(): void
    {
        $service = $this->client->productStocks();
        $this->assertInstanceOf(ProductStockService::class, $service);
    }

    /**
     * @test
     */
    public function it_caches_service_instances(): void
    {
        // İlk servis çağrısı
        $service1 = $this->client->categories();
        
        // Aynı servisin ikinci çağrısı
        $service2 = $this->client->categories();
        
        // Aynı örnek olduğunu doğrula
        $this->assertSame($service1, $service2);
    }
} 
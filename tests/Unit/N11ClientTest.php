<?php

namespace N11Api\N11SpApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use N11Api\N11SpApi\Services\Category\CategoryService;
use N11Api\N11SpApi\Services\City\CityService;
use N11Api\N11SpApi\Services\N11Client;
use N11Api\N11SpApi\Services\Order\OrderService;
use N11Api\N11SpApi\Services\Product\ProductService;
use N11Api\N11SpApi\Services\ProductSelling\ProductSellingService;
use N11Api\N11SpApi\Services\ProductStock\ProductStockService;
use N11Api\N11SpApi\Services\Shipment\ShipmentService;
use N11Api\N11SpApi\Services\ShipmentCompany\ShipmentCompanyService;

class N11ClientTest extends TestCase
{
    protected N11Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Test için N11Client örnekleme
        $this->client = new N11Client('test-app-key', 'test-app-secret', 'https://api.n11.com/ws/');
    }

    /**
     * @test
     */
    public function it_returns_category_service(): void
    {
        $service = $this->client->category();
        $this->assertInstanceOf(CategoryService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_city_service(): void
    {
        $service = $this->client->city();
        $this->assertInstanceOf(CityService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_order_service(): void
    {
        $service = $this->client->order();
        $this->assertInstanceOf(OrderService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_product_service(): void
    {
        $service = $this->client->product();
        $this->assertInstanceOf(ProductService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_shipment_service(): void
    {
        $service = $this->client->shipment();
        $this->assertInstanceOf(ShipmentService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_shipment_company_service(): void
    {
        $service = $this->client->shipmentCompany();
        $this->assertInstanceOf(ShipmentCompanyService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_product_selling_service(): void
    {
        $service = $this->client->productSelling();
        $this->assertInstanceOf(ProductSellingService::class, $service);
    }

    /**
     * @test
     */
    public function it_returns_product_stock_service(): void
    {
        $service = $this->client->productStock();
        $this->assertInstanceOf(ProductStockService::class, $service);
    }

    /**
     * @test
     */
    public function it_caches_service_instances(): void
    {
        // İlk servis çağrısı
        $service1 = $this->client->category();
        
        // Aynı servisin ikinci çağrısı
        $service2 = $this->client->category();
        
        // Aynı örnek olduğunu doğrula
        $this->assertSame($service1, $service2);
    }
} 
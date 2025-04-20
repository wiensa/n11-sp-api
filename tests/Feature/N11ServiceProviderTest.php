<?php

namespace N11Api\N11SpApi\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use N11Api\N11SpApi\Facades\N11;
use N11Api\N11SpApi\N11SpApiServiceProvider;
use N11Api\N11SpApi\N11Api;

class N11ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            N11SpApiServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'N11' => N11::class,
        ];
    }

    /**
     * Testlerden önce Laravel config ayarlarını yapıyoruz.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Geçici olarak API kimlik bilgilerini tanımlayalım
        Config::set('n11-sp-api.app_key', 'test-app-key');
        Config::set('n11-sp-api.app_secret', 'test-app-secret');
        Config::set('n11-sp-api.base_url', 'https://api.n11.com/ws/');
    }

    public function test_service_provider_registers_client(): void
    {
        // N11Api sınıfının container'a doğru bir şekilde kaydedildiğini kontrol edelim
        $client = $this->app->make(N11Api::class);
        $this->assertInstanceOf(N11Api::class, $client);
    }

    public function test_facade_works(): void
    {
        // N11 facade'inin çalıştığını kontrol edelim
        $this->assertInstanceOf(N11Api::class, N11::getFacadeRoot());
    }

    /**
     * @test
     */
    public function it_can_access_services_through_client(): void
    {
        // N11Api üzerinden servislere erişebildiğimizi kontrol edelim
        $client = $this->app->make(N11Api::class);

        $this->assertIsObject($client->categories());
        $this->assertIsObject($client->cities());
        $this->assertIsObject($client->orders());
        $this->assertIsObject($client->products());
        $this->assertIsObject($client->shipments());
        $this->assertIsObject($client->shipmentCompanies());
        $this->assertIsObject($client->productSellings());
        $this->assertIsObject($client->productStocks());
    }
} 
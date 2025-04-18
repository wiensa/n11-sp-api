<?php

namespace N11Api\N11SpApi\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use N11Api\N11SpApi\Facades\N11;
use N11Api\N11SpApi\N11SpApiServiceProvider;
use N11Api\N11SpApi\Services\N11Client;

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

    public function test_service_provider_registers_client(): void
    {
        // Geçici olarak API kimlik bilgilerini tanımlayalım
        Config::set('n11-sp-api.app_key', 'test-app-key');
        Config::set('n11-sp-api.app_secret', 'test-app-secret');

        // N11Client sınıfının container'a doğru bir şekilde kaydedildiğini kontrol edelim
        $client = $this->app->make(N11Client::class);
        $this->assertInstanceOf(N11Client::class, $client);
    }

    public function test_facade_works(): void
    {
        // Geçici olarak API kimlik bilgilerini tanımlayalım
        Config::set('n11-sp-api.app_key', 'test-app-key');
        Config::set('n11-sp-api.app_secret', 'test-app-secret');

        // N11 facade'inin çalıştığını kontrol edelim
        $this->assertInstanceOf(N11Client::class, N11::getFacadeRoot());
    }

    /**
     * @test
     */
    public function it_can_access_services_through_client(): void
    {
        // Geçici olarak API kimlik bilgilerini tanımlayalım
        Config::set('n11-sp-api.app_key', 'test-app-key');
        Config::set('n11-sp-api.app_secret', 'test-app-secret');

        // N11Client üzerinden servislere erişebildiğimizi kontrol edelim
        $client = $this->app->make(N11Client::class);

        $this->assertIsObject($client->category());
        $this->assertIsObject($client->city());
        $this->assertIsObject($client->order());
        $this->assertIsObject($client->product());
        $this->assertIsObject($client->shipment());
        $this->assertIsObject($client->shipmentCompany());
        $this->assertIsObject($client->productSelling());
        $this->assertIsObject($client->productStock());
    }
} 
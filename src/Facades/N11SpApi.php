<?php

namespace N11Api\N11SpApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \N11Api\N11SpApi\Services\Category\CategoryService categories()
 * @method static \N11Api\N11SpApi\Services\City\CityService cities()
 * @method static \N11Api\N11SpApi\Services\Order\OrderService orders()
 * @method static \N11Api\N11SpApi\Services\Product\ProductService products()
 * @method static \N11Api\N11SpApi\Services\Shipment\ShipmentService shipments()
 * @method static \N11Api\N11SpApi\Services\ShipmentCompany\ShipmentCompanyService shipmentCompanies()
 * @method static \N11Api\N11SpApi\Services\ProductSelling\ProductSellingService productSellings()
 * @method static \N11Api\N11SpApi\Services\ProductStock\ProductStockService productStocks()
 * 
 * @see \N11Api\N11SpApi\N11Api
 */
class N11SpApi extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'n11-sp-api';
    }
} 
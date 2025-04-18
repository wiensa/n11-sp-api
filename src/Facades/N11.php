<?php

namespace N11Api\N11SpApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \N11Api\N11SpApi\Services\Category\CategoryService category()
 * @method static \N11Api\N11SpApi\Services\City\CityService city()
 * @method static \N11Api\N11SpApi\Services\Order\OrderService order()
 * @method static \N11Api\N11SpApi\Services\Product\ProductService product()
 * @method static \N11Api\N11SpApi\Services\Shipment\ShipmentService shipment()
 * @method static \N11Api\N11SpApi\Services\ShipmentCompany\ShipmentCompanyService shipmentCompany()
 * @method static \N11Api\N11SpApi\Services\ProductSelling\ProductSellingService productSelling()
 * @method static \N11Api\N11SpApi\Services\ProductStock\ProductStockService productStock()
 * 
 * @see \N11Api\N11SpApi\Services\N11Client
 */
class N11 extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'n11-sp-api';
    }
} 
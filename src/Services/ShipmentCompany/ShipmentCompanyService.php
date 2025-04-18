<?php

namespace N11Api\N11SpApi\Services\ShipmentCompany;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\Services\N11Client;

class ShipmentCompanyService extends BaseService
{
    /**
     * ShipmentCompanyService constructor.
     */
    public function __construct(N11Client $client)
    {
        parent::__construct($client);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ShipmentCompanyService';
    }
    
    /**
     * N11 üzerinde tanımlı olan tüm kargo şirketlerini listeler.
     *
     * @return object
     */
    public function getShipmentCompanies(): object
    {
        return $this->call('GetShipmentCompanies');
    }
} 
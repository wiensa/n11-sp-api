<?php

namespace N11Api\N11SpApi\Services\ShipmentCompany;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\N11Api;

class ShipmentCompanyService extends BaseService
{
    /**
     * ShipmentCompanyService constructor.
     * 
     * @param N11Api $api N11 API istemcisi
     */
    public function __construct(N11Api $api)
    {
        parent::__construct($api);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ShipmentCompanyService';
    }
    
    /**
     * Kargo şirketlerini listeler.
     *
     * @return object
     */
    public function getShipmentCompanies(): object
    {
        return $this->callApi('GetShipmentCompanies');
    }
} 
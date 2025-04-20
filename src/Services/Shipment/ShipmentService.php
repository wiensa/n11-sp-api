<?php

namespace N11Api\N11SpApi\Services\Shipment;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\N11Api;

class ShipmentService extends BaseService
{
    /**
     * ShipmentService constructor.
     * 
     * @param N11Api $api N11 API istemcisi
     */
    public function __construct(N11Api $api)
    {
        parent::__construct($api);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ShipmentService';
    }
    
    /**
     * Kargo şablonu listesini döndürür.
     *
     * @return object
     */
    public function getShipmentTemplateList(): object
    {
        return $this->callApi('GetShipmentTemplateList');
    }
    
    /**
     * Kargo şablonu detaylarını döndürür.
     *
     * @param int $template_id Şablon ID
     * @return object
     */
    public function getShipmentTemplate(int $template_id): object
    {
        return $this->callApi('GetShipmentTemplate', [
            'id' => $template_id
        ]);
    }
} 
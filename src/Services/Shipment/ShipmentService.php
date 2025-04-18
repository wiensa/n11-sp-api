<?php

namespace N11Api\N11SpApi\Services\Shipment;

use N11Api\N11SpApi\Services\BaseService;
use N11Api\N11SpApi\Services\N11Client;

class ShipmentService extends BaseService
{
    /**
     * ShipmentService constructor.
     */
    public function __construct(N11Client $client)
    {
        parent::__construct($client);
        
        // Servis adını özel olarak ayarla
        $this->service_name = 'ShipmentService';
    }
    
    /**
     * Oluşturulan teslimat şablonu bilgilerini listelemek için kullanılan metoddur.
     *
     * @return object
     */
    public function getShipmentTemplateList(): object
    {
        return $this->call('GetShipmentTemplateList');
    }
    
    /**
     * Teslimat şablon ismi ile aratılan şablonun bilgilerini döndürür.
     *
     * @param string $template_name Şablon adı
     * @return object
     */
    public function getShipmentTemplate(string $template_name): object
    {
        return $this->call('GetShipmentTemplate', [
            'name' => $template_name
        ]);
    }
} 
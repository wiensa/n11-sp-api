<?php

namespace N11Api\N11SpApi\Traits;

use Illuminate\Support\Facades\Log;
use SoapFault;
use N11Api\N11SpApi\Exceptions\N11ApiException;

trait ApiRequest
{
    /**
     * SOAP metodu çağırır.
     *
     * @param string $service Servis adı
     * @param string $method Metot adı
     * @param array $params Parametreler
     * @param bool $use_cache Önbellek kullanılsın mı?
     * @return object|null SOAP yanıtı
     * @throws N11ApiException SOAP hatası durumunda
     */
    protected function call(string $service, string $method, array $params = [], bool $use_cache = true): ?object
    {
        try {
            // Servis adını otomatik tespit et
            if (empty($service) && $this->service_name) {
                $service = $this->service_name;
            }
            
            // N11Client aracılığıyla SOAP isteği gönder
            return $this->client->callSoapMethod($service, $method, $params, $use_cache);
        } catch (SoapFault $e) {
            return $this->handleSoapException($e, $service, $method, $params);
        }
    }
    
    /**
     * SOAP hatalarını yönetir.
     *
     * @param SoapFault $exception SOAP hatası
     * @param string $service Servis adı
     * @param string $method Metot adı
     * @param array $params Parametreler
     * @return never
     * @throws N11ApiException Her zaman
     */
    protected function handleSoapException(SoapFault $exception, string $service, string $method, array $params): never
    {
        $debug = config('n11-sp-api.debug', false);
        
        if ($debug) {
            Log::error('N11 SOAP Hatası', [
                'service' => $service,
                'method' => $method,
                'params' => $params,
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'faultcode' => $exception->faultcode ?? null,
                'faultstring' => $exception->faultstring ?? null
            ]);
        }
        
        $response = [
            'service' => $service,
            'method' => $method,
            'faultcode' => $exception->faultcode ?? null,
            'faultstring' => $exception->faultstring ?? null,
        ];
        
        throw new N11ApiException(
            $exception->getMessage() ?: 'N11 API hatası oluştu',
            $exception->getCode() ?: 0,
            $exception,
            $response
        );
    }
} 
<?php

namespace N11Api\N11SpApi\Exceptions;

use Exception;
use Throwable;

class N11ApiException extends Exception
{
    /**
     * Hata yanıtı.
     *
     * @var object|array|null
     */
    protected $response;

    /**
     * Hata oluşturucu.
     *
     * @param string $message Hata mesajı
     * @param int $code Hata kodu
     * @param Throwable|null $previous Önceki hata
     * @param object|array|null $response Hata yanıtı
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null, $response = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    /**
     * Hata yanıtını döndürür.
     *
     * @return object|array|null
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * İşlemin hata içerip içermediğini kontrol eder.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return true;
    }
    
    /**
     * Hata oluşan servisi döndürür.
     *
     * @return string|null
     */
    public function getService(): ?string
    {
        if (is_array($this->response) && isset($this->response['service'])) {
            return $this->response['service'];
        }
        
        return null;
    }
    
    /**
     * Hata oluşan metodu döndürür.
     *
     * @return string|null
     */
    public function getMethod(): ?string
    {
        if (is_array($this->response) && isset($this->response['method'])) {
            return $this->response['method'];
        }
        
        return null;
    }
    
    /**
     * Hata kodunu döndürür.
     *
     * @return string|null
     */
    public function getFaultCode(): ?string
    {
        if (is_array($this->response) && isset($this->response['faultcode'])) {
            return $this->response['faultcode'];
        }
        
        return null;
    }
    
    /**
     * Hata açıklamasını döndürür.
     *
     * @return string|null
     */
    public function getFaultString(): ?string
    {
        if (is_array($this->response) && isset($this->response['faultstring'])) {
            return $this->response['faultstring'];
        }
        
        return null;
    }
} 
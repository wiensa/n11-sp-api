<?php

namespace N11Api\N11SpApi\Traits;

trait ResponseFormatter
{
    /**
     * Yanıtı standart bir formata dönüştürür
     * 
     * @param object|array|null $response Ham yanıt
     * @param string|null $field_name Veri alanı adı
     * @param bool $is_collection Liste mi?
     * @return array|null Standartlaştırılmış yanıt
     */
    protected function formatResponse($response, ?string $field_name = null, bool $is_collection = false): ?array
    {
        if ($response === null) {
            return null;
        }
        
        // Önce yanıtı diziye dönüştür
        $response_array = $this->objectToArray($response);
        
        // Alan adı belirtilmişse o alanı al
        if ($field_name !== null && isset($response_array[$field_name])) {
            $data = $response_array[$field_name];
        } else {
            $data = $response_array;
        }
        
        // Koleksiyon ise standart koleksiyon formatına dönüştür
        if ($is_collection) {
            // Eğer zaten bir dizi değilse, dizi içine al
            if (!is_array($data) || !isset($data[0])) {
                $data = [$data];
            }
            
            return [
                'data' => $data,
                'total_count' => count($data),
                'has_error' => isset($response_array['result']) ? !$response_array['result']->getStatus() : false,
                'error_message' => isset($response_array['result']) ? $response_array['result']->getErrorMessage() : null
            ];
        }
        
        return $data;
    }
    
    /**
     * Koleksiyon yanıtını formatlar
     * 
     * @param object|array|null $response Ham yanıt
     * @param string|null $field_name Veri alanı adı
     * @return array|null Standartlaştırılmış yanıt
     */
    protected function formatCollectionResponse($response, ?string $field_name = null): ?array
    {
        return $this->formatResponse($response, $field_name, true);
    }
    
    /**
     * Tekil yanıtı formatlar
     * 
     * @param object|array|null $response Ham yanıt
     * @param string|null $field_name Veri alanı adı
     * @return array|null Standartlaştırılmış yanıt
     */
    protected function formatSingleResponse($response, ?string $field_name = null): ?array
    {
        return $this->formatResponse($response, $field_name, false);
    }
    
    /**
     * Nesneyi diziye dönüştürür
     * 
     * @param mixed $object Dönüştürülecek nesne
     * @return array Dizi
     */
    protected function objectToArray($object): array
    {
        if (is_array($object)) {
            return $object;
        }
        
        if (is_object($object)) {
            $array = [];
            foreach (get_object_vars($object) as $key => $value) {
                if (is_object($value) || is_array($value)) {
                    $array[$key] = $this->objectToArray($value);
                } else {
                    $array[$key] = $value;
                }
            }
            return $array;
        }
        
        return (array) $object;
    }
} 
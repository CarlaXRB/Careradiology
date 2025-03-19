<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OrthancService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        // La URL base de Orthanc (ajusta si es necesario)
        $this->baseUrl = "http://127.0.0.1:8042"; // Cambia la IP si Orthanc está en otro servidor
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 40.0,
            'auth' => ['orthanc', 'orthanc'] // Cambia las credenciales si las configuraste diferente
        ]);
    }

    // Obtener todos los estudios
    public function getStudies()
    {
        try {
            $response = $this->client->get('/studies');
            return json_decode($response->getBody(), true);
            //return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Obtener detalles de un estudio específico
    public function getStudy($studyId)
    {
        $response = $this->client->get("/studies/{$studyId}");
        return json_decode($response->getBody()->getContents(), true);
    }

    // Buscar imágenes DICOM
    public function searchImages($studyId)
    {
        $response = $this->client->get("/studies/{$studyId}/series");
        return json_decode($response->getBody()->getContents(), true);
    }
    
    public function getInstances($studyId)
    {
        try {
            $response = $this->client->get("/studies/{$studyId}/instances");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getInstanceFile($instanceId)
    {
        try {
            $response = $this->client->get("/instances/{$instanceId}/file");
            return $response->getBody();
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

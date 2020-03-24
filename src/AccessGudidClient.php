<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;

class AccessGudidClient
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param HttpClient|null $httpClient Client to do HTTP requests, if not set, auto discovery will be used to find a HTTP client.
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
    }
}

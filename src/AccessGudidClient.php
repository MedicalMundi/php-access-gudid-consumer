<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use RuntimeException;

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

    //TODO MAKE PRIVATE
    public function endpoint(string $queryString = ''): string
    {
        //return sprintf('https://%s/api/%s/%s', self::HOST, self::API_VERSION, $queryString);
        return sprintf('https://%s/api/%s/%s', AccessGudidApi::HOST, AccessGudidApi::API_VERSION, $queryString);
    }

    //TODO MAKE PRIVATE
    public function apiResource(string $resourceType, string $queryString = '', string $resourceFormat = AccessGudidApi::ALLOWED_FORMAT['json']): string
    {
        if (!in_array($resourceFormat, AccessGudidApi::ALLOWED_FORMAT)) {
            throw new \InvalidArgumentException('Invalid api format.');
        }

        return sprintf('%s.%s?%s', $resourceType, $resourceFormat, $queryString);
    }

    /**
     * @param string $httpEndpoint
     * @return string
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    private function doSend(string $httpEndpoint): string
    {
        $response = $this->httpClient->sendRequest(
            new Request(
                'GET',
                $httpEndpoint
            )
        );

        if (200 !== $response->getStatusCode()) {
            // TODO improve exception handeling - see php-http doc.
            throw new RuntimeException('Http error.');
        }

        return $response->getBody()->getContents();
    }

    public function parseUdi(string $udiCode): string
    {
        $queryString = sprintf('udi=%s', $this->percentEncoding($udiCode));

        $apiResource = $this->apiResource(AccessGudidApi::RESOURCE_PARSE_UDI, $queryString);

        $endpoint = $this->endpoint($apiResource);
        $jsonResponse = $this->doSend($endpoint);

        return $jsonResponse;
    }

    private function percentEncoding(string $url): string
    {
        return urldecode($url);
    }
}

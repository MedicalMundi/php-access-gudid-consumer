<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class AccessGudidHttpClient implements AccessGudidHttpClientInterface
{
    private const REQUEST_METHOD_GET = 'GET';

    /** @var HttpClientInterface */
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?? HttpClient::create();
    }

    private function endpoint(string $queryString = ''): string
    {
        return sprintf('https://%s/api/%s/%s', AccessGudidApi::HOST, AccessGudidApi::API_VERSION, $queryString);
    }

    private function apiResource(string $resourceType, string $queryString = '', string $resourceFormat = AccessGudidApi::ALLOWED_FORMAT['json']): string
    {
        if (!in_array($resourceFormat, AccessGudidApi::ALLOWED_FORMAT)) {
            throw new \InvalidArgumentException('Invalid api format.');
        }

        return sprintf('%s.%s?%s', $resourceType, $resourceFormat, $queryString);
    }

    private function percentEncoding(string $url): string
    {
        return urlencode($url);
    }

    /**
     * @param string $udiCode
     * @return ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getParseUdi(string $udiCode): ResponseInterface
    {
        $queryString = sprintf('udi=%s', $this->percentEncoding($udiCode));

        $apiResource = $this->apiResource(AccessGudidApi::RESOURCE_PARSE_UDI, $queryString);

        $endpoint = $this->endpoint($apiResource);

        return $this->httpClient->request(
            self::REQUEST_METHOD_GET,
            $endpoint,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                ],
            ]
        );
    }

    /**
     * @param string $deviceIdentifier
     * @param DeviceIdentifierType $deviceIdentifierType
     * @return ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getDevicesLookup(string $deviceIdentifier, DeviceIdentifierType $deviceIdentifierType): ResponseInterface
    {
        $queryString = '';

        if (DeviceIdentifierType::fullUniqueDeviceIdentifier()->equals($deviceIdentifierType)) {
            $queryString = sprintf('%s=%s', $deviceIdentifierType->value(), $this->percentEncoding($deviceIdentifier));
        }

        if (DeviceIdentifierType::DeviceIdentifier()->equals($deviceIdentifierType)) {
            $queryString = sprintf('%s=%s', $deviceIdentifierType->value(), $deviceIdentifier);
        }

        if (DeviceIdentifierType::publicRecordKey()->equals($deviceIdentifierType)) {
            $queryString = sprintf('%s=%s', $deviceIdentifierType->value(), $deviceIdentifier);
        }

        $apiResource = $this->apiResource(AccessGudidApi::RESOURCE_DEVICE_LOOKUP, $queryString);

        $endpoint = $this->endpoint($apiResource);

        return $this->httpClient->request(
            self::REQUEST_METHOD_GET,
            $endpoint,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                ],
            ]
        );
    }

    /**
     * @param string $deviceIdentifier
     * @param DeviceIdentifierType $deviceIdentifierType
     * @return ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getDevicesHistory(string $deviceIdentifier, DeviceIdentifierType $deviceIdentifierType): ResponseInterface
    {
        $queryString = '';

        if (DeviceIdentifierType::fullUniqueDeviceIdentifier()->equals($deviceIdentifierType)) {
            $queryString = sprintf('%s=%s', $deviceIdentifierType->value(), $this->percentEncoding($deviceIdentifier));
        }

        if (DeviceIdentifierType::DeviceIdentifier()->equals($deviceIdentifierType)) {
            $queryString = sprintf('%s=%s', $deviceIdentifierType->value(), $deviceIdentifier);
        }

        if (DeviceIdentifierType::publicRecordKey()->equals($deviceIdentifierType)) {
            $queryString = sprintf('%s=%s', $deviceIdentifierType->value(), $deviceIdentifier);
        }

        $apiResource = $this->apiResource(AccessGudidApi::RESOURCE_DEVICES_HISTORY, $queryString);

        $endpoint = $this->endpoint($apiResource);

        return $this->httpClient->request(
            self::REQUEST_METHOD_GET,
            $endpoint,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                ],
            ]
        );
    }
}

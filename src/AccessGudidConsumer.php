<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

final class AccessGudidConsumer
{
    /**
     * @var AccessGudidHttpClientInterface
     */
    private $httpClient;

    public function __construct(
        AccessGudidHttpClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
    }


    /**
     * @see https://accessgudid.nlm.nih.gov/resources/developers/parse_udi_api
     *
     * @param string $udiCode
     * @return string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function parseUdi(string $udiCode): string
    {
        $response = $this->httpClient->getParseUdi($udiCode); // doSend('GET', $endpoint);

        return $response->getContent();
    }

    /**
     * @see https://accessgudid.nlm.nih.gov/resources/developers/device_lookup_api
     *
     * @param string $identifier
     * @param DeviceIdentifierType $deviceIdentifierType
     * @return string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function devicesLookup(string $identifier, DeviceIdentifierType $deviceIdentifierType): string
    {
        $response = $this->httpClient->getDevicesLookup($identifier, $deviceIdentifierType);

        return $response->getContent();
    }

    /**
     * @param string $identifier
     * @param DeviceIdentifierType $deviceIdentifierType
     * @return string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function devicesHistory(string $identifier, DeviceIdentifierType $deviceIdentifierType): string
    {
        $response = $this->httpClient->getDevicesHistory($identifier, $deviceIdentifierType);

        return $response->getContent();
    }
}

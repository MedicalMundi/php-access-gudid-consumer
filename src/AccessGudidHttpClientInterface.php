<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface AccessGudidHttpClientInterface
{
    public function getParseUdi(string $udi): ResponseInterface;

    public function getDevicesLookup(string $deviceIdentifier, DeviceIdentifierType $deviceIdentifierType): ResponseInterface;

    public function getDevicesHistory(string $deviceIdentifier, DeviceIdentifierType $deviceIdentifierType): ResponseInterface;
}

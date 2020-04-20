<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface AccessGudidHttpClientInterface
{
    public function getParseUdi(string $udi): ResponseInterface;
}

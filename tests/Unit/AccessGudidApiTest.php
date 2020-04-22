<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid\Tests\Unit;

use MedicalMundi\AccessGudid\AccessGudidApi;
use PHPUnit\Framework\TestCase;

class AccessGudidApiTest extends TestCase
{
    /**
     * @test
     * @dataProvider  default_constant_provider
     */
    public function should_contains_default_constant($value, $expectedConstantValue): void
    {
        self::assertSame($expectedConstantValue, $value);
    }

    /**
     * @return \Generator <string|array>
     */
    public function default_constant_provider(): \Generator
    {
        yield [AccessGudidApi::HOST, 'accessgudid.nlm.nih.gov'];
        yield [AccessGudidApi::API_VERSION, 'v2'];
        yield [AccessGudidApi::ALLOWED_FORMAT, ['json' => 'json', 'xml' => 'xml']];
        yield [AccessGudidApi::RESOURCE_PARSE_UDI, 'parse_udi'];
        yield [AccessGudidApi::RESOURCE_DEVICE_LIST, 'devices/implantable/list'];
        yield [AccessGudidApi::RESOURCE_DEVICE_LOOKUP, 'devices/lookup'];
    }
}

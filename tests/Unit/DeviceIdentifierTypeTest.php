<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid\Tests\Unit;

use MedicalMundi\AccessGudid\DeviceIdentifierType;
use PHPUnit\Framework\TestCase;

class DeviceIdentifierTypeTest extends TestCase
{
    /** @test */
    public function create_as_full_unique_device_identifier(): void
    {
        $sut = DeviceIdentifierType::FullUniqueDeviceIdentifier();

        self::assertIsString($sut->value());
        self::assertEquals('udi', $sut->value());
    }

    /** @test */
    public function create_as_device_identifier(): void
    {
        $sut = DeviceIdentifierType::deviceIdentifier();

        self::assertIsString($sut->value());
        self::assertEquals('di', $sut->value());
    }

    /** @test */
    public function create_as_(): void
    {
        $sut = DeviceIdentifierType::publicRecordKey();

        self::assertIsString($sut->value());
        self::assertEquals('record_key', $sut->value());
    }
}

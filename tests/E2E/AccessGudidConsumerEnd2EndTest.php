<?php declare(strict_types=1);


namespace MedicalMundi\AccessGudid\Tests\E2E;

use Generator;
use MedicalMundi\AccessGudid\AccessGudidConsumer;
use MedicalMundi\AccessGudid\DeviceIdentifierType;
use PHPUnit\Framework\TestCase;

class AccessGudidConsumerEnd2EndTest extends TestCase
{
    private const WEB_RESPONSE_EXAMPLE_DIR = '/WebResponseExampleFixture/';
    /**
     * @test
     * @dataProvider udiCodeProvider
     */
    public function should_execute_parse_udi_request(string $udiCode, string $expectedData): void
    {
        self::markTestSkipped();
        $sut = new AccessGudidConsumer();

        $response = $sut->parseUdi($udiCode);

        self::assertSame($expectedData, $response);
    }

    /**
     * @return Generator <int, array<int, mixed>>
     */
    public function udiCodeProvider(): Generator
    {
        yield [
            '(01)00208851107345(17)150331',
            $jsonContent = file_get_contents(__DIR__ . self::WEB_RESPONSE_EXAMPLE_DIR . 'json_parse_udi_by_device_identifier_code.json'),
        ];

        yield [
            '=/A9999XYZ100T0944=,000025=A99971312345600=>014032=}013032&,1000000000000XYZ123',
            $jsonContent = file_get_contents(__DIR__ . self::WEB_RESPONSE_EXAMPLE_DIR . 'json_parse_udi_by_unique_device_identifier_code.json'),
        ];
    }

    /**
     * @test
     * @dataProvider devicesLookupProvider
     */
    public function should_execute_devices_lookup_request(string $identifier, DeviceIdentifierType $identifierType, string $expectedData): void
    {
        self::markTestSkipped();

        $sut = new AccessGudidConsumer();

        $response = $sut->devicesLookup($identifier, $identifierType);

        self::assertSame($expectedData, $response);
    }

    /**
     * @return \Generator & iterable<string, array<int, mixed>>
     */
    public function devicesLookupProvider(): Generator
    {
        yield 'devicesLookup with deviceIdentifier' => [
            '08717648200274',
            DeviceIdentifierType::deviceIdentifier(),
            $jsonContent = file_get_contents(__DIR__ . self::WEB_RESPONSE_EXAMPLE_DIR . 'json_devices_lookup_by_device_identifier_code.json'),
        ];

        yield 'devicesLookup with fullUniqueDeviceIdentifier' => [
            '=/08717648200274=,000025=A99971312345600=>014032=}013032&,1000000000000XYZ123',
            DeviceIdentifierType::fullUniqueDeviceIdentifier(),
            $jsonContent = file_get_contents(__DIR__ . self::WEB_RESPONSE_EXAMPLE_DIR . 'json_devices_lookup_by_unique_device_identifier_code.json'),
        ];

        yield 'devicesLookup with publicRecordKey' => [
            'f18845df-38a8-4fc2-8d26-5cce28c8b868',
            DeviceIdentifierType::publicRecordKey(),
            $jsonContent = file_get_contents(__DIR__ . self::WEB_RESPONSE_EXAMPLE_DIR . 'json_devices_lookup_by_public_record_key_code.json'),
        ];
    }

    /**
     * @test
     * @dataProvider devicesHistoryProvider
     */
    public function should_execute_devices_history_request(string $identifier, DeviceIdentifierType $identifierType, string $expectedData): void
    {
        self::markTestSkipped();
        $sut = new AccessGudidConsumer();

        $response = $sut->devicesHistory($identifier, $identifierType);

        self::assertSame($expectedData, $response);
    }

    /**
     * @return \Generator & iterable<string, array<int, mixed>>
     */
    public function devicesHistoryProvider(): Generator
    {
        yield 'devicesHistory with deviceIdentifier' => [
            '08717648200274',
            DeviceIdentifierType::deviceIdentifier(),
            $jsonContent = file_get_contents(__DIR__ . self::WEB_RESPONSE_EXAMPLE_DIR . 'json_devices_history_by_device_identifier_code.json'),
        ];

        yield 'devicesHistory with fullUniqueDeviceIdentifier' => [
            '=/08717648200274=,000025=A99971312345600=>014032=}013032&,1000000000000XYZ123',
            DeviceIdentifierType::fullUniqueDeviceIdentifier(),
            $jsonContent = file_get_contents(__DIR__ . self::WEB_RESPONSE_EXAMPLE_DIR . 'json_devices_history_by_unique_device_identifier_code.json'),
        ];

        yield 'devicesHistory with publicRecordKey' => [
            'f18845df-38a8-4fc2-8d26-5cce28c8b868',
            DeviceIdentifierType::publicRecordKey(),
            $jsonContent = file_get_contents(__DIR__ . self::WEB_RESPONSE_EXAMPLE_DIR . 'json_devices_history_by_public_record_key_code.json'),
        ];
    }
}

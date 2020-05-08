<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid\Tests\Unit;

use MedicalMundi\AccessGudid\AccessGudidHttpClient;
use MedicalMundi\AccessGudid\DeviceIdentifierType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AccessGudidHttpClientTest extends TestCase
{
    private const IRRELEVANT_IDENTIFIER = '0123456789';

    /** @var MockObject|HttpClientInterface */
    private $httpClient;

    /** @var AccessGudidHttpClient|null */
    private $accessGudidHttpClient;

    protected function setUp(): void
    {
        $this->httpClient = $this->getMockBuilder(HttpClientInterface::class)
            ->disableOriginalConstructor()->getMock();

        $this->accessGudidHttpClient = new AccessGudidHttpClient($this->httpClient);
    }

    /** @test */
    public function can_be_created_with_httpClient_as_param(): void
    {
        $GudidHttpClient = new AccessGudidHttpClient(HttpClient::create());

        self::assertInstanceOf(AccessGudidHttpClient::class, $GudidHttpClient);
    }

    /** @test */
    public function can_be_created_without_httpClient_as_param(): void
    {
        $GudidHttpClient = new AccessGudidHttpClient();

        self::assertInstanceOf(AccessGudidHttpClient::class, $GudidHttpClient);
    }

    /** @test */
    public function should_exec_call_getParseUdi(): void
    {
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()->getMock();

        $response->expects($this->any())
            ->method('getContent')
            ->willReturn(json_encode([['status' => 'success']]));

        $response->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->httpClient->expects($this->any())
            ->method('request')
            ->willReturn($response);

        $responseParseUdi = $this->accessGudidHttpClient->getParseUdi(self::IRRELEVANT_IDENTIFIER);

        $this->assertInstanceOf(ResponseInterface::class, $responseParseUdi);
        $this->assertEquals($responseParseUdi->getStatusCode(), 200);
        $content = $responseParseUdi->getContent();
        $this->assertNotEmpty($content);
        $this->assertIsString($content);
        $contentToArray = json_decode($content, true);
        $this->assertIsArray($contentToArray);
    }

    /**
     * @test
     * @dataProvider  deviceIdentifierTypeProvider
     */
    public function should_exec_call_getDevicesLookUp(DeviceIdentifierType $deviceIdentifierType): void
    {
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()->getMock();

        $response->expects($this->any())
            ->method('getContent')
            ->willReturn(json_encode([['status' => 'success']]));

        $response->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->httpClient->expects($this->any())
            ->method('request')
            ->willReturn($response);

        $responseDevicesLookup = $this->accessGudidHttpClient->getDevicesLookup(self::IRRELEVANT_IDENTIFIER, $deviceIdentifierType);

        $this->assertInstanceOf(ResponseInterface::class, $responseDevicesLookup);
        $this->assertEquals($responseDevicesLookup->getStatusCode(), 200);
        $content = $responseDevicesLookup->getContent();
        $this->assertNotEmpty($content);
        $this->assertIsString($content);
        $contentToArray = json_decode($content, true);
        $this->assertIsArray($contentToArray);
    }

    /**
     * @test
     * @dataProvider  deviceIdentifierTypeProvider
     */
    public function should_exec_call_getDevicesHistory(DeviceIdentifierType $deviceIdentifierType): void
    {
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()->getMock();

        $response->expects($this->any())
            ->method('getContent')
            ->willReturn(json_encode([['status' => 'success']]));

        $response->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->httpClient->expects($this->any())
            ->method('request')
            ->willReturn($response);

        $responseDevicesHistory = $this->accessGudidHttpClient->getDevicesHistory(self::IRRELEVANT_IDENTIFIER, $deviceIdentifierType);

        $this->assertInstanceOf(ResponseInterface::class, $responseDevicesHistory);
        $this->assertEquals($responseDevicesHistory->getStatusCode(), 200);
        $content = $responseDevicesHistory->getContent();
        $this->assertNotEmpty($content);
        $this->assertIsString($content);
        $contentToArray = json_decode($content, true);
        $this->assertIsArray($contentToArray);
    }

    /**
     * @return \Generator<DeviceIdentifierType[]>
     */
    public function deviceIdentifierTypeProvider(): \Generator
    {
        yield [DeviceIdentifierType::deviceIdentifier()];
        yield [DeviceIdentifierType::FullUniqueDeviceIdentifier()];
        yield [DeviceIdentifierType::publicRecordKey()];
    }

    protected function tearDown(): void
    {
        $this->accessGudidHttpClient = null;
    }
}

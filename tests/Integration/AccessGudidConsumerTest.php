<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid\Tests\Integration;

use MedicalMundi\AccessGudid\AccessGudidConsumer;
use MedicalMundi\AccessGudid\AccessGudidHttpClient;
use MedicalMundi\AccessGudid\AccessGudidHttpClientInterface;
use MedicalMundi\AccessGudid\DeviceIdentifierType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AccessGudidConsumerTest extends TestCase
{
    private const DEVICE_IDENTIFIER = '0123456789';

    /** @var AccessGudidConsumer */
    private $accessGudidConsumer;

    /** @var AccessGudidHttpClientInterface|MockObject */
    private $accessGudidHttpClient;

    protected function setUp(): void
    {
        $this->accessGudidHttpClient = $this->getMockBuilder(AccessGudidHttpClientInterface::class)
            ->disableOriginalConstructor()->getMock();

        $this->accessGudidConsumer = new AccessGudidConsumer($this->accessGudidHttpClient);
    }

    /** @test */
    public function can_be_created_with_httpClient_as_param(): void
    {
        $httpClient = HttpClient::create();

        $accessGudidHttpClient = new AccessGudidHttpClient($httpClient);

        $accessGudidConsumer = new AccessGudidConsumer($accessGudidHttpClient);

        self::assertInstanceOf(AccessGudidConsumer::class, $accessGudidConsumer);
    }

    /** @test */
    public function can_be_created_without_httpClient_as_param(): void
    {
        $accessGudidConsumer = new AccessGudidConsumer();

        self::assertInstanceOf(AccessGudidConsumer::class, $accessGudidConsumer);
    }

    /** @test */
    public function should_call_getParseUdi_of_httpClient(): void
    {
        $aCodeIdentifier = self::DEVICE_IDENTIFIER;
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()->getMock();

        $this->accessGudidHttpClient->expects($this->once())
            ->method('getParseUdi')
            ->with($aCodeIdentifier)
            ->willReturn($response)
        ;

        $this->accessGudidConsumer->parseUdi($aCodeIdentifier);
    }

    /** @test */
    public function should_call_getDevicesLookup_of_httpClient(): void
    {
        $aCodeIdentifier = self::DEVICE_IDENTIFIER;
        $aCodeIdentifierType = DeviceIdentifierType::deviceIdentifier();

        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()->getMock();

        $this->accessGudidHttpClient->expects($this->once())
            ->method('getDevicesLookup')
            ->with($aCodeIdentifier, $aCodeIdentifierType)
            ->willReturn($response)
        ;

        $this->accessGudidConsumer->devicesLookup($aCodeIdentifier, $aCodeIdentifierType);
    }

    /** @test */
    public function should_call_getDevicesHistory_of_httpClient(): void
    {
        $aCodeIdentifier = self::DEVICE_IDENTIFIER;
        $aCodeIdentifierType = DeviceIdentifierType::deviceIdentifier();

        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()->getMock();

        $this->accessGudidHttpClient->expects($this->once())
            ->method('getDevicesHistory')
            ->with($aCodeIdentifier, $aCodeIdentifierType)
            ->willReturn($response)
        ;

        $this->accessGudidConsumer->devicesHistory($aCodeIdentifier, $aCodeIdentifierType);
    }
}

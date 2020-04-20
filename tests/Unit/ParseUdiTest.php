<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid\Tests\Unit;

use MedicalMundi\AccessGudid\AccessGudidHttpClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ParseUdiTest extends TestCase
{
    /** @var HttpClientInterface|MockObject */
    protected $httpClient;

    /** @var AccessGudidHttpClient */
    protected $accessGudidHttpClient;

    protected function setUp(): void
    {
        $this->httpClient = $this->getMockBuilder(HttpClientInterface::class)
            ->disableOriginalConstructor()->getMock();

        $this->accessGudidHttpClient = new AccessGudidHttpClient($this->httpClient);
    }

    /** @test */
    public function parseUdi(): void
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

        $responseParseUdi = $this->accessGudidHttpClient->getParseUdi('xx');

        $this->assertInstanceOf(ResponseInterface::class, $responseParseUdi);
        $this->assertEquals($responseParseUdi->getStatusCode(), 200);
        $content = $responseParseUdi->getContent();
        $this->assertNotEmpty($content);
        $this->assertIsString($content);
        $contentToArray = json_decode($content, true);
        $this->assertIsArray($contentToArray);
    }
}

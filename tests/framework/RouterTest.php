<?php

use PHPUnit\Framework\TestCase;
use Framework\{Request, Router};
use Monolog\Logger;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;
    private $requestMock;


    public function setup(): void
    {
        parent::setUp();
        $this->requestMock = Mockery::mock(Request::class);
        $this->requestMock->shouldReceive('getMethod')->andReturn("GET");
        $logger = Mockery::mock(Logger::class);
        $this->router = new Router($this->requestMock, $logger);

    }

    /**
     * @return array
     */
    public function isUriMatchedDataProvider(): array
    {

        return [
            [
                "existedUri" => "users",
                "currentUri" => "users",
                "isUriMatched" => true,
            ],
            [
                "existedUri" => "users/{id}",
                "currentUri" => "users/1",
                "isUriMatched" => true,
            ],
            [
                "existedUri" => "users/{id}/orders",
                "currentUri" => "users/1/orders",
                "isUriMatched" => true,
            ],
            [
                "existedUri" => "users/{id}/orders/{orderId}",
                "currentUri" => "users/1/orders/2",
                "isUriMatched" => true,
            ],
            [
                "existedUri" => "users/{id}/orders/{orderId}",
                "currentUri" => "users/1/orders",
                "isUriMatched" => false,
            ],
            [
                "existedUri" => "users/{id}/orders",
                "currentUri" => "users/1/orders/2",
                "isUriMatched" => false,
            ],

        ];
    }

    /**
     * @param string $existedUri
     * @param string $currentUri
     * @param bool $isUriMatched
     *
     * @dataProvider isUriMatchedDataProvider
     * @return void
     */
    public function testIsUriMatched(string $existedUri, string $currentUri, bool $isUriMatched): void
    {
        $this->requestMock->shouldReceive('getUriPath')->andReturn($currentUri);
        $result = $this->router->isUriMatched($existedUri);
        $this->assertEquals($result, $isUriMatched);
    }

    /**
     * @return array
     */
    public function getAllParametersDataProvider(): array
    {
        return [
            [
                "existedUri" => "users",
                "currentUri" => "users",
                "params" => [],
            ],
            [
                "existedUri" => "users/{id}/orders",
                "currentUri" => "users/1/orders",
                "params" => [1],
            ],
            [
                "existedUri" => "users/{id}/orders/{orderId}",
                "currentUri" => "users/1/orders/2",
                "params" => [1, 2],
            ],
        ];
    }

    /**
     * @param string $existedUri
     * @param string $currentUri
     * @param array $params
     *
     * @dataProvider getAllParametersDataProvider
     * @return void
     */
    public function testGetAllParameters(string $existedUri, string $currentUri, array $params): void
    {
        $this->requestMock->shouldReceive('getUriPath')->andReturn($currentUri);
        $this->requestMock->shouldReceive('getQueryParams')->andReturn([]);
        $result = $this->router->getAllParameters($existedUri);
        $this->assertEquals($result, $params);
    }

}
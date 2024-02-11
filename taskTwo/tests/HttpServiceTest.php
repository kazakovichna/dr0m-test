<?php

namespace taskTwo\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use taskTwo\src\Service\HttpService\Exception\HttpServiceException;
use taskTwo\src\Service\HttpService\HttpService;

class HttpServiceTest extends TestCase
{
    private HttpService $httpService;

    protected function setUp(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['comment1', 'comment2'])),
            new Response(201),
            new Response(404),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $this->httpService = new HttpService($mockClient);
    }


    public function testGetComments(): void
    {
        $comments = $this->httpService->getComments();
        $this->assertIsArray($comments);
        $this->assertCount(2, $comments);
    }

    public function testGetCommentFailedRequest(): void
    {
        $mockHandler = new MockHandler([
            new Response(404),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $this->httpService = new HttpService($mockClient);

        $this->expectException(HttpServiceException::class);
        $this->httpService->getComments();
    }

    public function testAddComment(): void
    {
        $response = $this->httpService->addComment(['name' => 'testName', 'text' => 'New comment']);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAddCommentFailedRequest(): void
    {
        $mockHandler = new MockHandler([
            new Response(404),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $this->httpService = new HttpService($mockClient);

        $this->expectException(HttpServiceException::class);
        $this->httpService->addComment(['name' => 'testName', 'text' => 'New comment']);
    }

    public function testUpdateComment(): void
    {
        $response = $this->httpService->updateComment(1, ['name' => 'testName', 'text' => 'testText']);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateCommentFailedRequest(): void
    {
        $mockHandler = new MockHandler([
            new Response(404),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $this->httpService = new HttpService($mockClient);

        $this->expectException(HttpServiceException::class);
        $this->httpService->updateComment(1, ['name' => 'testName', 'text' => 'testText']);
    }
}
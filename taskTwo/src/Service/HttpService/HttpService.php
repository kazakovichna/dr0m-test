<?php

namespace taskTwo\src\Service\HttpService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use taskTwo\src\Service\HttpService\Exception\HttpServiceException;

class HttpService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     *
     * @throws HttpServiceException
     */
    public function getComments(): array
    {
        try{
            $response = $this->client->get('http://example.com/comments');
        } catch (GuzzleException $e) {
            throw new HttpServiceException("Failed to get comments: " . $e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @param array $data
     *
     * @return ResponseInterface
     *
     * @throws HttpServiceException
     */
    public function addComment(array $data): ResponseInterface
    {
        try{
            $response = $this->client->post('http://example.com/comment', ['json' => $data]);

            if ($response->getStatusCode() === 201 || $response->getStatusCode() === 200) {
                return $response;
            } else {
                throw new HttpServiceException(
                    "Failed to add comments, response with code: " . $response->getStatusCode()
                );
            }
        } catch (GuzzleException $e) {
            throw new HttpServiceException("Failed to get comments: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return ResponseInterface
     *
     * @throws HttpServiceException
     */
    public function updateComment(int $id, array $data): ResponseInterface
    {
        try{
            $response = $this->client->put("http://example.com/comment/{$id}", ['json' => $data]);

            if ($response->getStatusCode() === 200) {
                return $response;
            } else {
                throw new HttpServiceException(
                    "Failed to change comments, response with code: " . $response->getStatusCode()
                );
            }
        } catch (GuzzleException $e) {
            throw new HttpServiceException("Failed to get comments: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
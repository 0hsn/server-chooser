<?php

namespace App\Tests\Feature\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;


class SearchTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $client = HttpClient::create();
        $this->client = $client->withOptions([
            'base_uri' => 'http://127.0.0.1:8000',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function testSearchPassWithOutParam(): void
    {
        $response = $this->client->request('GET', '/api/servers');
        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = json_decode($response->getContent());
        $this->assertEquals(15, $responseBody->meta->per_pages);
    }
}

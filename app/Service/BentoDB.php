<?php

namespace App\Service;

use GuzzleHttp\Client;

/**
 * Lightweight wrapper for the BentoDB API.
 */
class BentoDB
{
    private Client $client;
    private string $api_url;
    private string $api_key;

    public function __construct(Client $client, string $api_url, string $api_key)
    {
        $this->client = $client;
        $this->api_url = $api_url;
        $this->api_key = $api_key;
    }

    public function getUser()
    {
        return $this->request('GET', $this->api_url . '/user');
    }

    public function createDatabase()
    {
        return $this->request('POST', $this->api_url . '/databases/create');
    }

    private function request(string $method, string $url)
    {

        $request = $this->client->$method($url, [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type'  => 'application/json',
            ],
        ]);

        $response = json_decode($request->getBody()->getContents());

        return $response;
    }
}
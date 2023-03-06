<?php

namespace App\Service;

use App\Exception\ApiKeyNotSetException;
use App\Exception\BentoDBException;
use App\Exception\UnauthorizedException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

/**
 * Lightweight wrapper for the BentoDB API.
 */
class BentoDB
{
    private Client $client;
    private string $api_url;
    private ?string $api_key;

    public function __construct(Client $client, string $api_url, ?string $api_key)
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
        if(!$this->api_key) {
            throw new ApiKeyNotSetException('API KEY not set. Run ./bentodb configure to set your API KEY');
        }

        try {
            $request = $this->client->$method($url, [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $this->api_key,
                    'Content-Type'  => 'application/json',
                ],
            ]);

            return json_decode($request->getBody()->getContents());
        }
        catch (ClientException $e) {
            switch($e->getCode()) {
                case 400:
                    $json = json_decode($e->getResponse()->getBody());
                    throw new BentoDBException($json->error, $e->getCode());
                case 401:
                    throw new UnauthorizedException('Invalid API Key', $e->getCode());
                default:
                    throw new BentoDBException($e->getResponse()->getReasonPhrase(), $e->getResponse()->getStatusCode());
            }
        }
        catch(ConnectException | ServerException $e) {
            throw new BentoDBException($e->getMessage(), $e->getCode());
        }
    }
}
<?php

namespace App\Classes;

use Exception;
use GuzzleHttp\Client;

class IpedAPI
{
    private $client_api;
    protected $base_uri = 'https://www.iped.com.br/api';
    protected $token;

    /**
     * IpedAPI constructor.
     */
    public function __construct() {
        $this->client_api = new Client([
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);
        $this->token = config('app.iped_token');

        return $this->client_api;
    }

    /**
     * @param $uri
     * @param string $method
     * @param array $query
     * @return array|mixed
     */
    protected function endpointRequest($uri, $method = 'GET', array $query = [])
    {
        try {
            $url = $this->base_uri . $uri;
            $query['query']['token'] = $this->token;
            $response = $this->client_api->request($method, $url, $query);
        } catch (Exception $e) {
            return [];
        }

        return $this->response_handler($response->getBody()->getContents());
    }

    /**
     * @param $response
     * @return array|mixed
     */
    protected function response_handler($response)
    {
        if ($response) {
            return json_decode($response);
        }
        return [];
    }

    /**
     * @param $uri
     * @param array $query
     * @return array|mixed
     */
    public function post($uri, array $query = [])
    {
        return $this->endpointRequest($uri, 'POST', $query);
    }

    /**
     * @param $uri
     * @param array $query
     * @return array|mixed
     */
    public function get($uri, array $query = [])
    {
        return $this->endpointRequest($uri, 'GET', $query);
    }

}

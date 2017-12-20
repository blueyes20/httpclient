<?php

namespace Cashuba\GuzzleClient;

use GuzzleHttp\Client as GClient;

class Client{

    private $client;

    public function __construct($baseUri)
    {
        $this->client = new GClient([
            'base_uri' => $baseUri,
        ]);
    }

    /**
     * @return mixed
     */
    public function getClient(){
        return $this->client;
    }

    public function get($route, $options=null){
        return $this->client->request('GET', $route, $options);
    }

    public function post($route, $options=null){
        return $this->client->request('POST', $route, $options);
    }

}
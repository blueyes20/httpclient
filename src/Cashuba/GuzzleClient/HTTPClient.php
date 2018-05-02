<?php

namespace Cashuba\GuzzleClient;

use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: desarrollo
 * Date: 30/04/18
 * Time: 9:50
 */
class HTTPClient {

    private $httpClient;
    private $options;

    public function __construct($baseUrl, $https=true)
    {
        $protocol = $https ? 'https://': 'http://';
        $this->httpClient = new Client([
            'base_uri' => $protocol . $baseUrl,
            'timeout' => 2.0
        ]);
        $this->options = [];
    }


    public function setAuth($user, $password) {
        $this->options['auth'] = [$user, $password];

        return $this;
    }

    public function setJson(array $data) {
        $this->options['json'] = $data;

        return $this;
    }

    public function setForm(array $data) {
        $this->options['form_params'] = $data;

        return $this;
    }

    public function setBearer($bearer) {
        $this->initHeaders();
        $this->options['headers']['Authorization'] = "Bearer $bearer";

        return $this;
    }

    private function initHeaders() {
        if(!array_key_exists('headers', $this->options)) {
            $this->options['headers'] = [];
        }
    }

    /**
     * @param string $path url path
     * @param bool $async flag to set up this request as asynchronous
     * @param null $thenCallback onSuccess callback if $async is true
     * @param null $catchCallback onError callback if $async is true
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException on synchronous requests
     */
    public function get($path, $async=false, $thenCallback=null, $catchCallback=null) {

        if(!$async) {
            return $this->httpClient->request('GET', $path, $this->options);
        } else {
            $this->httpClient->requestAsync('GET', $path, $this->options)->then($thenCallback, $catchCallback);
        }
    }

    /**
     * @param string $path url path
     * @param bool $async flag to set up this request as asynchronous
     * @param null $thenCallback onSuccess callback if $async is true
     * @param null $catchCallback onError callback if $async is true
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException on synchronous requests
     * @throws \Exception calling this method without set any data
     */
    public function post($path, $async=false, $thenCallback=null, $catchCallback=null) {
        $this->checkData();

        if(!$async) {
            return $this->httpClient->request('POST', $path, $this->options);
        } else {
            $this->httpClient->requestAsync('POST', $path, $this->options)->then($thenCallback, $catchCallback);
        }
    }

    /**
     * @param string $path url path
     * @param bool $async flag to set up this request as asynchronous
     * @param null $thenCallback onSuccess callback if $async is true
     * @param null $catchCallback onError callback if $async is true
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException on synchronous requests
     * @throws \Exception calling this method without set any data
     */
    public function put($path, $async=false, $thenCallback=null, $catchCallback=null) {
        $this->checkData();

        if(!$async) {
            return $this->httpClient->request('PUT', $path, $this->options);
        } else {
            $this->httpClient->requestAsync('PUT', $path, $this->options)->then($thenCallback, $catchCallback);
        }
    }

    /**
     * Like get() but decode synchronous responses to json
     * @param string $path url path
     * @param bool $async flag to set up this request as asynchronous
     * @param null $thenCallback onSuccess callback if $async is true
     * @param null $catchCallback onError callback if $async is true
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException on synchronous requests
     */
    public function getJson($path, $async=false, $thenCallback=null, $catchCallback=null) {

        if(!$async) {
            return json_decode($this->httpClient->request('GET', $path, $this->options)->getBody(), true);
        } else {
            $this->httpClient->requestAsync('GET', $path, $this->options)->then($thenCallback, $catchCallback);
        }
    }

    /**
     * Like post() but decode synchronous responses to json
     * @param string $path url path
     * @param bool $async flag to set up this request as asynchronous
     * @param null $thenCallback onSuccess callback if $async is true
     * @param null $catchCallback onError callback if $async is true
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException on synchronous requests
     * @throws \Exception calling this method without set any data
     */
    public function postJson($path, $async=false, $thenCallback=null, $catchCallback=null) {
        $this->checkData();

        if(!$async) {
            return json_decode($this->httpClient->request('POST', $path, $this->options)->getBody(), true);
        } else {
            $this->httpClient->requestAsync('POST', $path, $this->options)->then($thenCallback, $catchCallback);
        }
    }

    /**
     * Like put() but decode synchronous responses to json
     * @param string $path url path
     * @param bool $async flag to set up this request as asynchronous
     * @param null $thenCallback onSuccess callback if $async is true
     * @param null $catchCallback onError callback if $async is true
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException on synchronous requests
     * @throws \Exception calling this method without set any data
     */
    public function putJson($path, $async=false, $thenCallback=null, $catchCallback=null) {
        $this->checkData();

        if(!$async) {
            return json_decode($this->httpClient->request('PUT', $path, $this->options)->getBody(), true);
        } else {
            $this->httpClient->requestAsync('PUT', $path, $this->options)->then($thenCallback, $catchCallback);
        }
    }

    /**
     * @throws \Exception
     */
    private function checkData() {
        if(!array_key_exists('json', $this->options) && !array_key_exists('form_params', $this->options)) {
            throw new \Exception('Data not set with json or form, please call setJson() or setForm() first');
        }

        if(array_key_exists('json', $this->options) && array_key_exists('form_params', $this->options)) {
            throw new \Exception('Data set as json and form, please choose only one method to send data');
        }
    }




}

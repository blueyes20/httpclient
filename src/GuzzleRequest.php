<?php

namespace Cashuba\GuzzleClient;

class RequestOptions{

    private $options;

    private function __construct(){
        $this->options = array();
    }

    public static function builder(){
        return new RequestOptions();
    }

    public function setHttpAuth($user, $passwd){
        $this->options['auth'] = array($user, $passwd);
        return $this;
    }

    public function setConnectionTimeout($timeout){
        $this->options['connect_timeout'] = $timeout;
        return $this;
    }

    public function setResponseTimeout($timeout){
        $this->options['timeout'] = $timeout;
        return $this;
    }

    public function setHeaders($dictionary){
        $this->options['headers'] = $dictionary;
        return $this;
    }

    public function setBody($json){
        $this->options['json'] = $json;
        return $this;
    }

    public function setMultipartFormData(...$multipart){
        $this->options['multipart'] = array();
        foreach ($multipart as $argument){
            array_push($this->options['multipart'], $argument);
        }
        return $this;
    }

    public function setQuery($dictionary){
        $this->options['query'] = $dictionary;
        return $this;
    }

    public function create(){
        return $this->options;
    }
}
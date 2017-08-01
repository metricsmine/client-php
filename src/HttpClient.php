<?php

namespace Metricsmine;

class HttpClient {

    protected $config = [];
    protected $curl;

    public static function forge(array $config) {
        return new static($config);
    }

    public function __construct(array $config) {
        $this->config = $config;
        $this->curl = curl_init($url);
        curl_setopt($this->curl, CURLOPT_POST, true);
    }

    public function send() {
        if (!$this->curl) {
            return;
        }

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'X-Auth-Token: ' . $this->options['key']['private'],
            'Content-type: application/x-www-form-urlencoded',
        ]);


        curl_setopt($this->curl, CURLOPT_TIMEOUT, 2);
        curl_setopt($this->curl, CURLOPT_NOSIGNAL, 2);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($this->curl);
    }

}

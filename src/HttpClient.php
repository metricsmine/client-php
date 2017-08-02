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


        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_POST, true);

        curl_setopt($this->curl, CURLOPT_TIMEOUT, 2);
        curl_setopt($this->curl, CURLOPT_NOSIGNAL, 2);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    public function send($options) {
        if (!$this->curl) {
            return;
        }

        $url = 'https://' . $this->config['code'] . '.metricsmine.com/api/'
            . $this->config['key']['public'] . '/logs'
            . '/' . $this->config['service']
            . ($this->config['instance'] ? '/' . $this->config['instance'] : '')
//            . '/'
        ;

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'X-Auth-Token: ' . $options['key']['private'],
            'Content-type: application/x-www-form-urlencoded',
        ]);

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query([
//            'service' => $options['service'],
//            'instance' => $options['instance'],
            'type' => $options['type'],
            'format' => $options['format'],
            'message' => (!empty($options['message']) && !is_string($options['message'])) ? json_encode($options['message']) : (string) $options['message'],
            'backtrace' => empty($options['backtrace']) ? null : json_encode($options['backtrace']),
            'file' => $options['file'],
            'line' => $options['line'],
            'url' => $options['url'],
        ]));

        curl_exec($this->curl);
    }

}

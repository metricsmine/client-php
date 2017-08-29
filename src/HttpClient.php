<?php

namespace metricsmine\clientPHP;

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

    public function send($options, $endpoint) {
        if (!$this->curl) {
            return;
        }

        $url = 'https://' . $this->config['code'] . '.metricsmine.com/api/'
            . $this->config['key']['public'] . $endpoint;

        $fields = [];

        switch ($endpoint) {
            case '/logs':
                $url .= '/' . $this->config['service']
                    . ($this->config['instance'] ? '/' . $this->config['instance'] : '');


                $fields = [
//            'service' => $options['service'],
//            'instance' => $options['instance'],
                    'type'       => $options['type'],
                    'format'     => $options['format'],
                    'title'      => (!empty($options['title']) ? (string) $options['title'] : ''),
                    'message'    => (!empty($options['message']) && is_scalar($options['message'])) ? (string) $options['message'] : json_encode($options['message']),
                    'stacktrace' => empty($options['stacktrace']) ? null : json_encode($options['stacktrace']),
                    'file'       => $options['file'],
                    'line'       => $options['line'],
                    'url'        => $options['url'],
                ];
                break;
            case '/metrics':
//                $url .= '/' . $this->config['service']
//                    . ($this->config['instance'] ? '/' . $this->config['instance'] : '');
                break;
        }

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'X-Auth-Token: ' . $this->config['key']['private'],
            'Content-type: application/x-www-form-urlencoded',
        ]);

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($fields));

        curl_exec($this->curl);
    }

}

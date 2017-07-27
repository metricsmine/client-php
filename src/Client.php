<?php

namespace Metricsmine;

class Client {

    private $options = [
        'code' => 'api',
        'service' => 'php',
        'instance' => null,
        'key' => [
            'public' => null,
            'private' => null,
        ],
        'type' => 'log',
        'format' => 'plain',
        'message' => null,
        'trace' => false,
        'file' => null,
        'line' => null,
        'url' => null,
    ];

    public function __construct($options = []) {
        $this->options['instance'] = gethostname();
        $this->options = array_merge($this->options, $options);
    }

    public static function forge($options = []) {
        return new static($options);
    }

    public function service($name) {
        $this->options['service'] = $name;
        return $this;
    }

    public function keys($public, $private, $code = null) {
        $this->options['code'] = $code;
        $this->options['key']['public'] = $public;
        $this->options['key']['private'] = $private;
        return $this;
    }

    public function instance($name) {
        $this->options['instance'] = $name;
        return $this;
    }

    public function type($name) {
        $this->options['type'] = $name;
        return $this;
    }

    public function message($name) {
        $this->options['message'] = $name;
        return $this;
    }

    public function trace() {
        $this->options['trace'] = true;
        return $this;
    }

    public function url($name) {
        $this->options['url'] = $name;
        return $this;
    }

    public function file($name, $line) {
        $this->options['file'] = $name;
        $this->options['line'] = $line;
        return $this;
    }

    public function send_log() {

        if ($this->options['trace']) {

            $trace_arr = [];
            $trace = (array) debug_backtrace();

            if (is_string($this->options['message'])) {
                $this->options['format'] = 'plain';
            } else {
                $this->options['format'] = 'json';
            }
            foreach ($trace as $i => $frame) {
//                $line_str = "#$i\t";
                $line_arr = [];
                if (!isset($frame['file'])) {
//                    $line_str .= '[internal function]';
                    $line_arr['file'] = 'internal function';
                } else {
//                    $line_str .= $frame['file'] . ':' . $frame['line'];
                    $line_arr['file'] = $frame['file'];
                    $line_arr['line'] = (int) $frame['line'];
                }
//                $line_str .= "\t";
                if (isset($frame['function'])) {
                    $line_arr['function'] = '';

                    if (isset($frame['class'])) {
//                        $line_str .= $frame['class'] . '::';
                        $line_arr['function'] = $frame['class'] . '::';
                    }
//                    $line_str .= $frame['function'] . '()';
                    $line_arr['function'] .= $frame['function'] . '()';
                }
//                $line_str = trim($line_str);
                $trace_arr['#' . $i] = $line_arr;
            }
            $trace_str = print_r($trace_arr, true);

            if (is_string($this->options['message'])) {
                $this->options['message'] .= "\n" . $trace_str;
            } elseif (is_array($this->options['message'])) {
                $this->options['message']['trace'] = $trace_arr;
            } elseif (is_object($this->options['message'])) {
                $this->options['message']->trace = (Object) $trace_arr;
            }
            unset($trace_str, $trace_arr);
        }

        $url = 'https://' . $this->options['code'] . '.metricsmine.com/api/'
            . $this->options['key']['public'] . '/logs'
            . '/' . $this->options['service']
            . ($this->options['instance'] ? '/' . $this->options['instance'] : '')
//            . '/'
        ;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
//            'service' => $this->options['service'],
//            'instance' => $this->options['instance'],
            'type' => $this->options['type'],
            'format' => $this->options['format'],
            'message' => (!empty($this->options['message']) && !is_string($this->options['message'])) ? json_encode($this->options['message']) : (string) $this->options['message'],
            'file' => $this->options['file'],
            'line' => $this->options['line'],
            'url' => $this->options['url'],
        ]));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'X-Auth-Token: ' . $this->options['key']['private'],
            'Content-type: application/x-www-form-urlencoded',
        ]);

        curl_setopt($curl, CURLOPT_TIMEOUT, 2);
        curl_setopt($curl, CURLOPT_NOSIGNAL, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);

        return true;
    }

}

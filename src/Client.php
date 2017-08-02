<?php

namespace Metricsmine;

class Client {

    protected $config = [
        'code'     => 'api',
        'service'  => 'php',
        'instance' => null,
        'key'      => [
            'public'  => null,
            'private' => null,
        ],
    ];
    private $options  = [
        'type'       => 'log',
        'format'     => 'plain',
        'message'    => null,
        'trace'      => false,
        'stacktrace' => null,
        'file'       => null,
        'line'       => null,
        'url'        => null,
    ];

    public function __construct($public, $private, $code = null) {
        $this->config['code']           = $code;
        $this->config['key']['public']  = $public;
        $this->config['key']['private'] = $private;
        $this->config['instance']       = gethostname();
    }

    public static function forge($public, $private, $code = null) {
        return new static($public, $private, $code);
    }

    public function __set($name, $value, $second = null) {
        $this->options[$name] = $value;
        if ($name == 'file') {
            $this->options['file'] = $value;
            $this->options['line'] = $second;
        }
        return $this;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }
    }

    public function notify($report, $message) {
        if (!$report instanceof Throwable && !$report instanceof Exception) {
            $this->message($report . ' - ' . $message);
            $this->options['stacktrace'] = \Stacktrace::forge($this->config);
        } else {

            $this->message(get_class($report) . ' - ' . $report->getMessage())
                    ->options['stacktrace'] = \Stacktrace::forge($this->config, $report->getTrace(), $report->getFile(), $report->getLine());

//            if (method_exists($report, 'getPrevious')) {
//                $this->setPrevious($report->getPrevious());
//            }
        }
        
        $client = HttpClient::forge($this->config);
        $url    = 'https://' . $this->config['code'] . '.metricsmine.com/api/'
                . $this->config['key']['public'] . '/logs'
                . '/' . $this->config['service']
                . ($this->config['instance'] ? '/' . $this->config['instance'] : '')
//            . '/'
        ;

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
//            'service' => $this->options['service'],
//            'instance' => $this->options['instance'],
            'type'      => $this->type(),
            'format'    => $this->options['format'],
            'message'   => (!empty($this->options['message']) && !is_string($this->options['message'])) ? json_encode($this->options['message']) : (string) $this->options['message'],
            'backtrace' => empty($this->options['backtrace']) ? null : json_encode($this->options['backtrace']),
            'file'      => $this->options['file'],
            'line'      => $this->options['line'],
            'url'       => $this->options['url'],
        ]));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'X-Auth-Token: ' . $this->options['key']['private'],
            'Content-type: application/x-www-form-urlencoded',
        ]);


        return $this;
    }


}

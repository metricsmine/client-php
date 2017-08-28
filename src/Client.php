<?php

namespace metricsmine\clientPHP;

use metricsmine\clientPHP\Stacktrace;
use metricsmine\clientPHP\HttpClient;
use metricsmine\clientPHP\ErrorTypes;

class Client {

    protected $config = [
        'code' => 'api',
        'service' => 'php',
        'instance' => null,
        'key' => [
            'public' => null,
            'private' => null,
        ],
    ];
    private $options = [
        'type' => 'log',
        'format' => 'plain',
        'message' => null,
        'trace' => false,
        'stacktrace' => null,
        'file' => null,
        'line' => null,
        'url' => null,
    ];

    public function __construct($public, $private, $code = null) {
        $this->config['code'] = $code;
        $this->config['key']['public'] = $public;
        $this->config['key']['private'] = $private;
        $this->config['instance'] = gethostname();
    }

    public static function forge($public, $private, $code = null) {
        return new static($public, $private, $code);
    }

    public function __set($name, $value) {
        $this->options[$name] = $value;
        return $this;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }
    }

    public function notify($report, $message = null) {
        if (!$report instanceof Throwable && !$report instanceof Exception) {

            $type_name = is_numeric($report) ? ErrorTypes::getSeverity($report) : $report;
            $this
                ->message($type_name . ' - ' . $message)
                ->type($type_name)
                ->stacktrace(Stacktrace::forge($this->config));
        } else {
            $this
                ->message(get_class($report) . ' - ' . $report->getMessage())
                ->type(ErrorTypes::getSeverity($report->getType()))
                ->stacktrace(Stacktrace::forge($this->config, $report->getTrace(), $report->getFile(), $report->getLine()));

//            if (method_exists($report, 'getPrevious')) {
//                $this->setPrevious($report->getPrevious());
//            }
        }

        $client = HttpClient::forge($this->config);

        $client->send($this->options);



        return $this;
    }

}

<?php

namespace metricsmine\clientPHP;

use metricsmine\clientPHP\Stacktrace;
use metricsmine\clientPHP\HttpClient;
use metricsmine\clientPHP\ErrorTypes;

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
    private $options = [
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
        \Arr::set($this->config, 'instance', gethostname());
        \Arr::set($this->config, 'code', $code);
        \Arr::set($this->config, 'key.public', $public);
        \Arr::set($this->config, 'key.private', $private);
    }

    public static function forge($public, $private, $code = null) {
        return new static($public, $private, $code);
    }

    public function __call(string $name, $values) {
        if (empty($values)) {
            return \Arr::set($this->options, $name);
        }
        \Arr::set($this->options, $name, current($values));
        return $this;
    }

    public function notify($report, $message = null) {
        if (!$report instanceof Throwable && !$report instanceof Exception) {

            $type_name = is_numeric($report) ? ErrorTypes::getSeverity($report) : $report;
            if (is_scalar($report)) {
                $this->message($type_name . ' - ' . $message);
            } else {
                $this->message($message);
            }
            $this
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

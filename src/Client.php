<?php

namespace Metricsmine;

class Client {

    private $options = [];

    public function __construct($options = []) {
        $this->options = $options;
    }

    public static function forge($options = []) {
        return new static($options);
    }

}

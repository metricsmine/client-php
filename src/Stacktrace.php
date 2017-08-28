<?php

namespace metricsmine\client-php;

class Stacktrace {

    protected $config = [];
    protected $frames = [];

    public static function forge(array $config, array $backtrace = null, string $file = '[generator]', int $line = 0) {

        // Reduce memory usage by omitting args and objects from backtrace
        empty($backtrace)
            and $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS & ~DEBUG_BACKTRACE_PROVIDE_OBJECT);

        return new static($config, $backtrace, $file, $line);
    }

    public static function __construct(array $config, array $backtrace, $topFile, $topLine) {
        $this->config = $config;

        // PHP backtrace's are misaligned, we need to shift the file/line down a frame
        foreach ($backtrace as $frame) {
            if (!static::frameInsideVendor($frame)) {
                $this->addFrame(
                    $topFile, $topLine, isset($frame['function']) ? $frame['function'] : null, isset($frame['class']) ? $frame['class'] : null
                );
            }

            if (isset($frame['file']) && isset($frame['line'])) {
                $topFile = $frame['file'];
                $topLine = $frame['line'];
            } else {
                $topFile = '[internal]';
                $topLine = 0;
            }
        }

        // Add a final stackframe for the "main" method
        $this->addFrame($topFile, $topLine, '[main]');

        return $this;
    }

    public static function frameInsideVendor(array $frame) {
        return isset($frame['class']) && stripos($frame['class'], 'metricsmine\\') === 0 && substr_count($frame['class'], '\\') === 1;
    }

    public function addFrame($file, $line, $method, $class = null) {
        // Account for special "filenames" in eval'd code
        $matches = [];
        if (preg_match("/^(.*?)\((\d+)\) : (?:eval\(\)'d code|runtime-created function)$/", $file, $matches)) {
            $file = $matches[1];
            $line = $matches[2];
        }

        // Construct the frame
        $frame = [
            'lineNumber' => (int) $line,
            'method' => $class ? "$class::$method" : $method,
        ];

        // Attach some lines of code for context
        $frame['code'] = $this->getCode($file, $line, static::NUM_LINES);

        // Strip out project Root from start of file path?
        $frame['file'] = $file;

        $this->frames[] = $frame;
    }

    protected function getCode($path, $line, $numLines) {
        if (empty($path) || empty($line) || !file_exists($path)) {
            return;
        }

        try {
            $file = new SplFileObject($path);
            $file->seek(PHP_INT_MAX);

            $bounds = static::getBounds($line, $numLines, $file->key() + 1);

            $code = [];

            $file->seek($bounds[0] - 1);
            while ($file->key() < $bounds[1]) {
                $code[$file->key() + 1] = rtrim(substr($file->current(), 0, static::MAX_LENGTH));
                $file->next();
            }

            return $code;
        } catch (RuntimeException $ex) {
            // do nothing
        }
    }

    protected static function getBounds($line, $num, $max) {
        $start = max($line - floor($num / 2), 1);

        $end = $start + ($num - 1);

        if ($end > $max) {
            $end = $max;
            $start = max($end - ($num - 1), 1);
        }

        return [$start, $end];
    }

}

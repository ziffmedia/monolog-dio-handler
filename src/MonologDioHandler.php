<?php

namespace ZiffMedia\MonologDioHandler;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;

class MonologDioHandler extends AbstractProcessingHandler
{
    /**
     * @var resource
     */
    protected $resource;

    public function __construct(protected string $path, $level = Logger::DEBUG, bool $bubble = true, FormatterInterface $formatter = null)
    {
        parent::__construct($level, $bubble);

        if (null !== $formatter) {
            $this->setFormatter($formatter);
        }
    }

    public function close(): void
    {
        if (is_resource($this->resource)) {
            dio_close($this->resource);
        }

        parent::close();
    }

    protected function write(LogRecord $record): void
    {
        if (! is_resource($this->resource)) {
            $this->resource = dio_open($this->path, O_WRONLY);
        }

        dio_write($this->resource, (string) $record['formatted']);
    }

    protected function getDefaultFormatter(): LineFormatter
    {
        return new LineFormatter();
    }
}
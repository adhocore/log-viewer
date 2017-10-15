<?php

namespace Ahc\Log\File;

use Ahc\Log\Item;
use Ahc\Log\LogInterface;
use Ahc\Log\ReaderInterface;

/**
 * @package logviewer
 * @author  Jitendra Adhikari <jiten.adhikary at gmail dot com>
 */
class Reader implements ReaderInterface
{
    /** @var LogInterface */
    protected $log;

    /** @var \SplFileObject */
    protected $handler;

    /** @var int */
    protected $offset = 1;

    public function __construct(LogInterface $log)
    {
        $this->log = $log;

        $this->inithandler();
    }

    /**
     * Inits the file reading handler.
     *
     * @return void
     */
    protected function initHandler()
    {
        $this->handler = new \SplFileObject($this->getLog()->getPath());

        $this->handler->setFlags(\SplFileObject::DROP_NEW_LINE);
    }

    /**
     * {@inheritdoc}
     */
    public function getLog(): LogInterface
    {
        return $this->log;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNext(): bool
    {
        return $this->handler->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function read(int $offset, int $batchSize): array
    {
        if ($offset === -1) {
            $offset = $this->getEndOffset($batchSize);
        }

        $this->offset = $offset;

        $data = [];
        while ($batchSize--) {
            // The handler uses 0 based key.
            $this->handler->seek($offset - 1);

            $data[] = new Item($offset++, $this->handler->current());

            if (!$this->hasNext()) {
                break;
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndOffset(int $batchSize): int
    {
        $this->handler->seek(PHP_INT_MAX);

        $offset = $this->handler->key();

        return $offset - ($offset % $batchSize) + 1; // +1 fixes for 0 based key.
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}

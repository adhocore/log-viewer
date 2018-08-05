<?php

/*
 * This file is part of the LOG-VIEWER package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\Log;

/**
 * @author  Jitendra Adhikari <jiten.adhikary at gmail dot com>
 */
interface ReaderInterface
{
    /**
     * Gets the log instance that this reader processes.
     *
     * @return LogInterface The log instance.
     */
    public function getLog(): LogInterface;

    /**
     * Read and return the log data as per the underlying the Log instance.
     *
     * @param int $offset    The start line/index number (1 based). Use -1 to rewind to last.
     * @param int $batchSize The total number of log items to read in a go.
     *
     * @return array|LogItem[] Array of LogItem.
     */
    public function read(int $offset, int $batchSize): array;

    /**
     * Tells if there is next page of logs available.
     *
     * @return bool
     */
    public function hasNext(): bool;

    /**
     * Get the beginning offset for the end most chunk of logs.
     *
     * @param int $batchSize The total number of log items to read in a go.
     *
     * @return int
     */
    public function getEndOffset(int $batchSize): int;

    /**
     * Get current offset.
     *
     * @return int
     */
    public function getOffset(): int;
}

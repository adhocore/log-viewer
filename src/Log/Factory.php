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

use Ahc\Log\Exception\InvalidTypeException;
use Ahc\Log\File\Log as FileLog;
use Ahc\Log\File\Reader as FileReader;

/**
 * @author  Jitendra Adhikari <jiten.adhikary at gmail dot com>
 */
class Factory
{
    const READER_TYPE_FILE = 'file';

    const DEFAULT_BATCH_SIZE = 10;

    /**
     * Create reader instance using given arguments.
     *
     * @param string      $type
     * @param string      $path
     * @param string|null $allowedPath
     *
     * @return ReaderInterface
     */
    public static function createReader(string $type, string $path, string $allowedPath = null): ReaderInterface
    {
        switch ($type) {
            case self::READER_TYPE_FILE:
                return new FileReader(
                    new FileLog($path, $allowedPath ?? getenv('LOG_PATH'))
                );
        }

        throw new InvalidTypeException(sprintf('Type "%s" not yet implemented', $type), 400);
    }
}

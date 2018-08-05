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
interface LogInterface
{
    /**
     * Gets the path/identifier where the log can be retrieved from.
     *
     * For a file logger, it might be absolute file path of log.
     * For a database logger, it might be the database.table schema.
     *
     * @return string
     */
    public function getPath(): string;
}

<?php

/*
 * This file is part of the LOG-VIEWER package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

use Ahc\Log\Factory;
use Ahc\Log\File\Reader;

class FactoryTest extends TestCase
{
    public function testCreateReader()
    {
        putenv('LOG_PATH=tests/stub');

        $reader = Factory::createReader('file', 'log.log');

        $this->assertInstanceOf(Reader::class, $reader);
    }

    /**
     * @expectedException \Ahc\Log\Exception\InvalidTypeException
     * @expectedExceptionMessage Type "n/a" not yet implemented
     */
    public function testCreateReaderThrows()
    {
        Factory::createReader('n/a', '_');
    }
}

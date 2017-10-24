<?php

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

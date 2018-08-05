<?php

/*
 * This file is part of the LOG-VIEWER package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

use Ahc\Log\File\Log;
use Ahc\Log\LogInterface;

class LogTest extends TestCase
{
    protected $logfile = __DIR__ . '/../../stub/log.log';

    public function testNew()
    {
        $log = $this->newLog();

        $this->assertInstanceOf(LogInterface::class, $log);
    }

    /**
     * @expectedException \Ahc\Log\Exception\InvalidPathException
     * @expectedExceptionMessage The allowed path is invalid
     */
    public function testSetAllowedPathThrows()
    {
        $this->newLog()->setAllowedPath('it-doesnt_exist');
    }

    /**
     * @expectedException \Ahc\Log\Exception\InvalidPathException
     * @expectedExceptionMessage The log path is invalid
     */
    public function testSetPathThrows()
    {
        $this->newLog()->setPath('it_doesnt/exist.too');
    }

    /**
     * @expectedException \Ahc\Log\Exception\InvalidPathException
     * @expectedExceptionMessage The log path is not in allowed path
     */
    public function testSetPathThrowsWhenPathNotAllowed()
    {
        $this->newLog()->setPath(__FILE__);
    }

    public function testGetAllowedPath()
    {
        $log = $this->newLog()->setAllowedPath(__DIR__);

        $this->assertSame(__DIR__, $log->getAllowedPath());
    }

    public function testGetPath()
    {
        $log = $this->newLog()->setAllowedPath(__DIR__)->setPath(__FILE__);

        $this->assertSame(__FILE__, $log->getPath());
    }

    protected function newLog()
    {
        return new Log($this->logfile, dirname($this->logfile));
    }
}

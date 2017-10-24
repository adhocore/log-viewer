<?php

use Ahc\Log\File\Log;
use Ahc\Log\File\Reader;
use Ahc\Log\ItemInterface;
use Ahc\Log\LogInterface;
use Ahc\Log\ReaderInterface;

class ReaderTest extends TestCase
{
    protected $logfile = __DIR__ . '/../../stub/log.log';

    public function testNew()
    {
        $reader = $this->newReader();

        $this->assertInstanceOf(ReaderInterface::class, $reader);
    }

    public function testGetLog()
    {
        $log = $this->newReader()->getLog();

        $this->assertInstanceOf(LogInterface::class, $log);
    }

    public function testHasNext()
    {
        $reader = $this->newReader();

        $this->assertTrue($reader->hasNext(), 'Should have next chunk');

        $reader->read(2, count(file($this->logfile))); // Read everything.

        $this->assertFalse($reader->hasNext(), 'Should no longer have next chunk');
    }

    public function testRead()
    {
        $reader = $this->newReader();
        $data   = $reader->read(1, $count = 3);

        $this->assertTrue(is_array($data));
        $this->assertNotEmpty($data);

        foreach ($data as $key => $row) {
            $this->assertInstanceOf(ItemInterface::class, $row);
        }

        $this->assertSame($data[0]->toArray(), ['offset' => 1, 'body' => 'this']);
        $this->assertSame($data[1]->toArray(), ['offset' => 2, 'body' => 'is']);

        $this->assertSame($count, count($data), 'Should have N items when next chunk exists');

        $data = $reader->read(13, $count = 6);
        $this->assertLessThanOrEqual($count, count($data), 'Should have 1-N items when next chunk dont exist');
    }

    public function testGetEndOffset()
    {
        $reader = $this->newReader();

        $this->assertSame(11, $reader->getEndOffset(10), 'Should be 11 for batchSize 10 with 18 lines');
        $this->assertSame(17, $reader->getEndOffset(8), 'Should be 17 for batchSize 8 with 18 lines');
    }

    public function testGetOffset()
    {
        $reader = $this->newReader();

        $this->assertSame(1, $reader->getOffset(), 'Should be 1 as default offset');

        // Read last chunk!
        $reader->read(-1, 5);

        $this->assertSame(16, $reader->getOffset(), 'Should be 16 for last chunk with batchSize 5');
        $this->assertSame(
            $reader->getEndOffset(5),
            $reader->getOffset(),
            'Should have same The endOffset and offset for last chunk'
        );
    }

    protected function newReader()
    {
        return new Reader(new Log($this->logfile, dirname($this->logfile)));
    }
}

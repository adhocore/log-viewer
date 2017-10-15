<?php

use Ahc\Log\Item;
use Ahc\Log\ItemInterface;

class ItemTest extends TestCase
{
    public function testNew()
    {
        $item = $this->newItem(1, 'log_' . rand());

        $this->assertInstanceOf(ItemInterface::class, $item);
        $this->assertInstanceOf(\JsonSerializable::class, $item);
    }

    public function testGetOffset()
    {
        $item = $this->newItem($offset = rand(), $body = 'log_' . rand());

        $this->assertSame($offset, $item->getOffset());
    }

    public function testGetBody()
    {
        $item = $this->newItem($offset = rand(), $body = 'log_' . rand());

        $this->assertSame($body, $item->getBody());
    }

    public function testToArray()
    {
        $item = $this->newItem($offset = rand(), $body = 'log_' . rand());

        $this->assertSame(compact('offset', 'body'), $item->toArray());
    }

    public function testJsonSerialize()
    {
        $item = $this->newItem($offset = rand(), $body = 'log_' . rand());

        $this->assertSame(json_encode(compact('offset', 'body')), json_encode($item), 'Should be jsonable');
        $this->assertSame($item->toArray(), $item->jsonSerialize(), 'Should be same as toArray');
    }

    protected function newItem(int $offset, string $body)
    {
        return new Item($offset, $body);
    }	
}

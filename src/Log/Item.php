<?php

namespace Ahc\Log;

/**
 * @author  Jitendra Adhikari <jiten.adhikary at gmail dot com>
 */
class Item implements ItemInterface
{
    /** @var int */
    protected $offset;

    /** @var string */
    protected $body;

    public function __construct(int $offset, string $body)
    {
        $this->offset = $offset;
        $this->body   = $body;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'offset' => $this->getOffset(),
            'body'   => $this->getBody(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}

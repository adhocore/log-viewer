<?php

namespace Ahc\Log;

/**
 * @author  Jitendra Adhikari <jiten.adhikary at gmail dot com>
 */
interface ItemInterface extends \JsonSerializable
{
    /**
     * Get the ordinal offset of log item.
     *
     * For file logger it could be line number.
     * For database logger it could be the primary ID.
     *
     * @return int $offset
     */
    public function getOffset(): int;

    /**
     * Get the log content/body.
     *
     * @return string $body
     */
    public function getBody(): string;

    /**
     * Gets the array representation of log data.
     *
     * @return array The array must of the form ['offset' => 1, 'body' => 'text'].
     */
    public function toArray(): array;
}

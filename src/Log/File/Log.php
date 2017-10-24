<?php

namespace Ahc\Log\File;

use Ahc\Log\Exception\InvalidPathException;
use Ahc\Log\LogInterface;

/**
 * @author  Jitendra Adhikari <jiten.adhikary at gmail dot com>
 */
class Log implements LogInterface
{
    /** @var string Current log path */
    protected $path;

    /** @var string The whitelisted path from where logs are allowed to read */
    protected $allowedPath;

    /**
     * Constructor.
     *
     * @param string $path        The absolute file path.
     * @param string $allowedPath The whitelisted path.
     */
    public function __construct(string $path, string $allowedPath)
    {
        $this->setAllowedPath($allowedPath);

        $this->setPath($path);
    }

    /**
     * Set the whitelist/allowed path for log.
     *
     * @param string $path The directory. Resolve from app root/base path if relative!
     *
     * @return Log
     */
    public function setAllowedPath(string $path): Log
    {
        // Resolve from app root/base path if relative!
        if (!$this->isAbsolute($path)) {
            $path = base_path($path);
        }

        if (!is_dir($path)) {
            throw new InvalidPathException('The allowed path is invalid', 500);
        }

        $this->allowedPath = realpath($path);

        return $this;
    }

    /**
     * Set the full log file path.
     *
     * @param string $path The file path. Resolve from allowed path if relative!
     *
     * @return Log
     */
    public function setPath(string $path): Log
    {
        // Resolve from allowed path if relative!
        if (!$this->isAbsolute($path)) {
            $path = $this->allowedPath . '/' . $path;
        }

        if (!is_file($path)) {
            throw new InvalidPathException('The log path is invalid', 400);
        }

        $path = realpath($path);

        if (!$this->isPathAllowed($path)) {
            throw new InvalidPathException('The log path is not in allowed path', 403);
        }

        $this->path = $path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Gets the allowed/whitelisted path.
     *
     * @return string
     */
    public function getAllowedPath(): string
    {
        return $this->allowedPath;
    }

    /**
     * Platform agnostic absolute path detection.
     *
     * @param string $path
     *
     * @return bool
     */
    protected function isAbsolute(string $path): bool
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return strpos($path, ':') > 0;
        }

        return ($path[0] ?? '') === '/';
    }

    /**
     * Check if given path falls under allowed path.
     *
     * @param string $path
     *
     * @return bool
     */
    protected function isPathAllowed(string $path): bool
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return stripos($path, $this->allowedPath) === 0;
        }

        return strpos($path, $this->allowedPath) === 0;
    }
}

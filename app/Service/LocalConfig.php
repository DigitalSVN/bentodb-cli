<?php

namespace App\Service;

/**
 * Load from and maintain the local config file
 */
class LocalConfig
{
    public static function loadFromFile(): array
    {
        if (! is_dir(dirname(static::filePath()))) {
            mkdir(dirname(static::filePath()), 0755, true);
        }

        $config = [];
        if (file_exists(static::filePath())) {
            $config = json_decode(file_get_contents(static::filePath()), true);
        }

        return $config;
    }

    public static function set(string $key, mixed $value)
    {
        $config = static::loadFromFile();

        $config[$key] = $value;

        file_put_contents(static::filePath(), json_encode($config, JSON_PRETTY_PRINT));
    }

    private static function filePath(): string
    {
        return __DIR__ . '/../../.bentodb/config.json';
    }
}
<?php declare(strict_types=1);

namespace LogCleaner;

class LogCleanerFactory
{
    public static function create(string $configFilePath): LogCleanerInterface
    {
        if (!file_exists($configFilePath) || !is_readable($configFilePath)) {
            throw new \RuntimeException("Configuration file not found or not readable: $configFilePath");
        }

        $config = require $configFilePath;
        if (!isset($config['log_storage'])) {
            throw new \RuntimeException("Missing required configuration key log_storage.");
        }

        return match($config['log_storage']) {
            'file' => new FileLogCleaner($config['file']['path']),
            'db' => new DbLogCleaner(),
            default => throw new \RuntimeException("Error! Unknown log storage. Please check config."),
        };
    }
}
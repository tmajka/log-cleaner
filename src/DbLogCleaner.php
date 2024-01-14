<?php

declare(strict_types=1);

namespace LogCleaner;

class DbLogCleaner implements LogCleanerInterface
{
    public function cleanLogsOlderThan(string $date): int
    {
        return 100;
    }

    public function getLogInfoOlderThan(string $date): int
    {
        return 50;
    }
}


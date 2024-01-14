<?php

declare(strict_types=1);

namespace LogCleaner;

interface LogCleanerInterface
{
    /**
     * @param string $date
     * @return int
     */
    public function cleanLogsOlderThan(string $date): int;

    /**
     * @param string $date
     * @return int
     */
    public function getLogInfoOlderThan(string $date): int;
}
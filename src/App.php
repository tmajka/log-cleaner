<?php

declare(strict_types=1);

namespace LogCleaner;

class App
{
    private LogCleanerInterface $cleaner;
    private int $rowCount = 0;

    public function __construct(LogCleanerInterface $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    public function cleanLog(string $date): string
    {
        return sprintf('Removed %s log rows until %s', $this->cleaner->cleanLogsOlderThan($date), $date);
    }

    public function readLog(string $date): string
    {
        $this->rowCount = $this->cleaner->getLogInfoOlderThan($date);
        return sprintf('Logs contains %s row to unset until %s', $this->rowCount, $date);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
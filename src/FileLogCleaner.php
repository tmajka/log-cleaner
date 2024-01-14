<?php

declare(strict_types=1);

namespace LogCleaner;

use RuntimeException;
use SplFileObject;

class FileLogCleaner implements LogCleanerInterface
{
    private ?SplFileObject $file;

    public function __construct(string $logFilePath) {

        if (!file_exists($logFilePath) || !is_writable($logFilePath)) {
            throw new RuntimeException("Log file does not exist or is not writable: " . $logFilePath);
        }
        $this->file = new SplFileObject($logFilePath);
    }

    public function cleanLogsOlderThan(string $date): int
    {
        $temporaryFilePath = $this->file->getPath() . '/temporary.log';
        $outputFile = new SplFileObject($temporaryFilePath, 'w');

        $callback = function($line) use ($outputFile) {
            $outputFile->fwrite($line);
        };

        try {
            $output = $this->processLogs($date, $callback);
            $this->replaceLogFile($temporaryFilePath);
        } finally {
            @unlink($temporaryFilePath);
        }

        return $output;
    }

    public function getLogInfoOlderThan(string $date): int
    {
        return $this->processLogs($date);
    }

    private function processLogs(string $date, callable $callback = null): int
    {
        $this->file->rewind();
        $rowCount = 0;
        $enteredTimestamp = strtotime($date);

        $noop = function($line) {};
        $callback = $callback ?? $noop;

        while (!$this->file->eof()) {
            $line = $this->file->fgets();
            if (!$line) continue;
            $dateInline = substr($line, 1, 19);
            $lineTimestamp = strtotime($dateInline);

            if ($lineTimestamp < $enteredTimestamp) {
                $rowCount++;
            } else {
                $callback($line);
            }
        }

        return $rowCount;
    }

    private function replaceLogFile($temporaryFilePath): void
    {
        $originalFilePath = $this->file->getPathname();

        $this->file = null;

        if (!rename($temporaryFilePath, $originalFilePath)) {
            throw new RuntimeException("Cannot replace old log file with new file.");
        }
    }

}

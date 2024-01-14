<?php declare(strict_types=1);

use LogCleaner\FileLogCleaner;
use PHPUnit\Framework\TestCase;

class FileLogCleanerTest extends TestCase
{
    private FileLogCleaner $fileLogCleaner;
    private string $tempLogFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempLogFile = sys_get_temp_dir() . '/test.log';
        file_put_contents($this->tempLogFile, "2023-01-01 15:30:00 Test log entry\n");
        $this->fileLogCleaner = new FileLogCleaner($this->tempLogFile);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->tempLogFile)) {
            unlink($this->tempLogFile);
        }
    }

    public function testCleanLogsOlderThanWithValidDate()
    {
        $this->assertEquals(1, $this->fileLogCleaner->cleanLogsOlderThan('2023-01-02 00:00:00'));
    }

    public function testGetLogInfoOlderThanWithValidDate()
    {
        $this->assertEquals(1, $this->fileLogCleaner->getLogInfoOlderThan('2023-01-02 00:00:00'));
    }

    public function testConstructWithNonexistentFile()
    {
        $logFilePath = '/nonexistent/path.log';
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Log file does not exist or is not writable: " . $logFilePath);
        new FileLogCleaner($logFilePath);
    }
}

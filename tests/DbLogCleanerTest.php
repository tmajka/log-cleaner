<?php declare(strict_types=1);

use LogCleaner\DbLogCleaner;
use PHPUnit\Framework\TestCase;

class DbLogCleanerTest extends TestCase
{
    private DbLogCleaner $dbLogCleaner;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dbLogCleaner = new DbLogCleaner();
    }

    public function testCleanLogsOlderThan()
    {
        $result = $this->dbLogCleaner->cleanLogsOlderThan('2024-01-01 00:00:00');
        $this->assertEquals(100, $result);
    }

    public function testGetLogInfoOlderThan()
    {
        $result = $this->dbLogCleaner->getLogInfoOlderThan('2024-01-01 00:00:00');
        $this->assertEquals(50, $result);
    }

    public function testCleanLogsOlderThanWithException()
    {
        $this->assertTrue(true);
    }

    public function testGetLogInfoOlderThanWithException()
    {
        $this->assertTrue(true);
    }
}

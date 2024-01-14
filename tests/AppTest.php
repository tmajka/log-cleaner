<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use LogCleaner\App;
use LogCleaner\LogCleanerInterface;

class AppTest extends TestCase
{
    private $mockLogCleaner;
    private App $app;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $this->mockLogCleaner = $this->createMock(LogCleanerInterface::class);
        $this->app = new App($this->mockLogCleaner);
    }

    public function testCleanLog(): void
    {
        $this->mockLogCleaner
            ->expects($this->once())
            ->method('cleanLogsOlderThan')
            ->with($this->equalTo('2024-01-01'))
            ->willReturn(10);

        $result = $this->app->cleanLog('2024-01-01');
        $this->assertEquals('Removed 10 log rows until 2024-01-01', $result);
    }

    public function testReadLog(): void
    {
        $this->mockLogCleaner
            ->expects($this->once())
            ->method('getLogInfoOlderThan')
            ->with($this->equalTo('2024-01-01'))
            ->willReturn(5);

        $result = $this->app->readLog('2024-01-01');
        $this->assertEquals('Logs contains 5 row to unset until 2024-01-01', $result);
    }

    public function testGetRowCount(): void
    {
        $this->mockLogCleaner
            ->method('getLogInfoOlderThan')
            ->willReturn(5);

        $this->app->readLog('2024-01-01');
        $rowCount = $this->app->getRowCount();

        $this->assertEquals(5, $rowCount);
    }
}
<?php

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use LogCleaner\LogCleanerFactory;
use LogCleaner\FileLogCleaner;
use LogCleaner\DbLogCleaner;

class LogCleanerFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        vfsStream::setup('root', null, [
            'validFileConfig.php' => "<?php return ['log_storage' => 'file', 'file' => ['path' => 'vfs://root/logFile.log']];",
            'validDbConfig.php' => "<?php return ['log_storage' => 'db'];",
            'invalidConfig.php' => "<?php return [];",
            'unknownStorageConfig.php' => "<?php return ['log_storage' => 'unknown'];",
            'logFile.log' => "",
        ]);
    }

    public function testCreateWithValidFileStorageConfig(): void
    {
        $configFilePath = vfsStream::url('root/validFileConfig.php');
        $cleaner = LogCleanerFactory::create($configFilePath);

        $this->assertInstanceOf(FileLogCleaner::class, $cleaner);
    }

    public function testCreateWithValidDbStorageConfig(): void
    {
        $configFilePath = vfsStream::url('root/validDbConfig.php');
        $cleaner = LogCleanerFactory::create($configFilePath);

        $this->assertInstanceOf(DbLogCleaner::class, $cleaner);
    }

    public function testCreateWithInvalidConfigFilePath(): void
    {
        $configFilePath = vfsStream::url('root/nonexistentConfig.php');
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Configuration file not found or not readable: " . $configFilePath);

        LogCleanerFactory::create($configFilePath);
    }

    public function testCreateWithUnknownStorageConfig(): void
    {
        $configFilePath = vfsStream::url('root/unknownStorageConfig.php');
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Error! Unknown log storage. Please check config.");
        LogCleanerFactory::create($configFilePath);
    }
}

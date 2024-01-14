<?php declare(strict_types=1);

use LogCleaner\DateValidator;
use PHPUnit\Framework\TestCase;

class DateValidatorTest extends TestCase
{
    private DateValidator $testObject;
    protected function setUp() : void
    {
        parent::setUp();
        $this->testObject =  new DateValidator();
    }

    public function testValidDateFormat()
    {
        $this->testObject->validate('2024-01-14 12:30:15');
        $this->assertTrue(true);
    }

    public function testInvalidDateFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid input date format.');
        $this->testObject->validate('invalid-date');
    }

    public function testFutureDate()
    {
        $futureDate = (new DateTime('now'))->modify('+1 day')->format('Y-m-d H:i:s');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The date cannot be in the future.');
        $this->testObject->validate($futureDate);
    }
}
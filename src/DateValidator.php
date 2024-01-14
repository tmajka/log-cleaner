<?php

declare(strict_types=1);

namespace LogCleaner;

use DateTime;
use InvalidArgumentException;

class DateValidator
{
    private const DATA_FORMAT = 'Y-m-d H:i:s';
    public function validate(string $date): void
    {
        $d = DateTime::createFromFormat(self::DATA_FORMAT, $date);
        $currentDate = new DateTime();

        if (!($d && $d->format(self::DATA_FORMAT) === $date)) {
            throw new InvalidArgumentException('Invalid input date format.' );
        }

        if ($d > $currentDate) {
            throw new InvalidArgumentException('The date cannot be in the future.');
        }
    }
}
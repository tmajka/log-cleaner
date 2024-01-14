<?php

use LogCleaner\App;
use LogCleaner\DateValidator;
use LogCleaner\LogCleanerFactory;

require_once __DIR__ . '/../../../../vendor/autoload.php';

$options = getopt("", [ "configFile:"]);
$configFilePath = $options['configFile'] ?? __DIR__ . '/../etc/env.php';

echo "Welcome to Logs Cleaner :)" . PHP_EOL;

do {
    echo PHP_EOL
        . "Enter date (e.g. 2024-01-14 18:30:15) to which we will delete the logs."
        . PHP_EOL;

    $enteredDate = trim(fgets(STDIN));

    try {
        $validator = new DateValidator();
        $validator->validate($enteredDate);

        $cleaner = LogCleanerFactory::create($configFilePath);
        $app = new App($cleaner);
        echo $app->readLog($enteredDate);

        if ($app->getRowCount() > 0) {
            echo PHP_EOL . "Do you confirm deleting this data? (y/n): ";
            $confirmation = trim(fgets(STDIN));

            if (strtolower($confirmation) === 'y') {
                echo $app->cleanLog($enteredDate);
            }
        }
    } catch (InvalidArgumentException|RuntimeException $e) {
        echo $e->getMessage() . PHP_EOL;
    } catch (Exception $e) {
        echo "Error occurred while the program was running. Check message: " . $e->getMessage() . PHP_EOL;
    }

    echo PHP_EOL . "Do you want to perform another operation? (y/n): ";
    $continue = strtolower(trim(fgets(STDIN)));

} while ($continue === 'y');

echo PHP_EOL . "Log Cleaner has finished processing. See you again!" . PHP_EOL;

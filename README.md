<h1 align="center">Log Cleaner</h1> 

<div align="center">
  <p>Small program that analyzing logs and removing records older than given time period</p>
  <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/license-MIT-blue.svg" /></a>
</div>


## Installation details

#### Install by composer

```
composer require tmajka/log-cleaner
composer install
```
#### Info
* Before run, set path to log file in *log-cleaner/etc/env.php*
* We assume that the timestamp appears at the beginning of each line in the log file and is compliant with ISO 8601, as recommended by RFC 5424 for Syslog.
```
[2023-01-14T15:30:45.123456+02:00]
```


## Command to run

```
php vendor/tmajka/log-cleaner/bin/clean.php
```
### Run with custom config file
```
php vendor/tmajka/log-cleaner/bin/clean.php -configFile=path/to/config/file.php
```
## Run Test
```
cd vendor/tmajka/log-cleaner
```
```
composer install
```
```
./vendor/bin/phpunit
```

## License

[MIT](https://opensource.org/licenses/MIT)


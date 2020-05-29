# Trainjunkies - Schedule JSON Parser

![CI](https://github.com/trainjunkies-packages/schedule-json-parser/workflows/CI/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/trainjunkies-packages/schedule-json-parser/v)](https://packagist.org/packages/trainjunkies-packages/schedule-json-parser)
[![License](https://poser.pugx.org/trainjunkies-packages/schedule-json-parser/license)](https://packagist.org/packages/trainjunkies-packages/schedule-json-parser)

PHP package to parse Network Rail Schedule JSON file.

## Installation

### via Composer

Install [Composer](https://getcomposer.org/doc/00-intro.md)  and require the package with the below command.

```bash
composer.phar require trainjunkies-packages/schedule-json-parser
```
## Getting Started

### Network Rail Objects

JSON Records can be converted into associative arrays by using the `TrainjunkiesPackages\ScheduleJsonParser\Factory` class.

```php
$handler = TrainjunkiesPackages\ScheduleJsonParser\Factory::create($jsonFilePath);

$meta = function($data) {
    var_dump($data);
};

$tiploc = function($data) {
    var_dump($data);
};

$association = function($data) {
    var_dump($data);
};

$schedule = function($data) {
    var_dump($data);
};

try {
    $handler->parse(
        $callback,
        $callback,
        $callback,
        $callback
    );
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}
```

Example scripts can be found in the `./scripts` directory.

Further information on the fields and their values can be found in the [Open Rail Data Wiki](https://wiki.openraildata.com/index.php?title=JSON_File_Format)

## Development

See [CONTRIBUTING.md](https://github.com/trainjunkies-packages/schedule-json-parser/blob/master/CONTRIBUTING.md) for development practices.

## Authors

- **Ben McManus** - [bennoislost](https://github.com/bennoislost)

See also the list of [contributors](https://github.com/trainjunkies-packages/schedule-json-parser/contributors) who participated in this project

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

- [https://groups.google.com/forum/#!forum/openraildata-talk](https://groups.google.com/forum/#!forum/openraildata-talk)
- [https://wiki.openraildata.com/](https://wiki.openraildata.com/)

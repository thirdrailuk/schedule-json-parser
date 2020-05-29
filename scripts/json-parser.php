<?php

use TrainjunkiesPackages\ScheduleJsonParser\Factory;

include __DIR__ . '/../vendor/autoload.php';

$jsonFilePath = $argv[1] ?? false || die('Please specify a JSON Schedule file' . PHP_EOL);

$handler = Factory::create($jsonFilePath);

$callback = function($data) {
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

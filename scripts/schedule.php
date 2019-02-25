<?php

use TrainjunkiesPackages\NetworkRailScheduleFileParser\ScheduleFactory;

include __DIR__ . "/../vendor/autoload.php";

try {
    $file = __DIR__ . '/../resources/network-rail/schedule';
    $schedules = ScheduleFactory::createScheduleFileParser($file);

    foreach ($schedules->each() as $line) {
        $data = json_decode($line, true);
        echo sprintf(
            'UID: "%s", TOC: "%s"',
            $data["JsonScheduleV1"]["CIF_train_uid"],
            $data["JsonScheduleV1"]["atoc_code"]
        ) . PHP_EOL;
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

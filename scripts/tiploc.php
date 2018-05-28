<?php

use TrainjunkiesPackages\NetworkRailScheduleFileParser\TiplocFactory;

include __DIR__ . "/../vendor/autoload.php";

try {
    $file = __DIR__ . '/../resources/network-rail/schedule';
    $tiplocs = TiplocFactory::createTiplocFileParser($file);
    $tiplocs->get(function($line) {
        $data = json_decode($line, true);
        echo sprintf(
            "Location: %s",
            $data['TiplocV1']['tps_description']
        ) . PHP_EOL;
    });
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

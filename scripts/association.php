<?php

use TrainjunkiesPackages\NetworkRailScheduleFileParser\AssociationFactory;

include __DIR__ . "/../vendor/autoload.php";

try {
    $file = __DIR__ . '/../resources/network-rail/schedule';
    $association = AssociationFactory::createAssociationFileParser($file);
    $association->get(function($line) {
        $data = json_decode($line, true);
        echo sprintf(
               'Main Train UID: "%s", Assoc. Train UID: "%s", Tiploc: "%s"',
                $data["JsonAssociationV1"]["main_train_uid"],
                $data["JsonAssociationV1"]["assoc_train_uid"],
                $data["JsonAssociationV1"]["location"]
            ) . PHP_EOL;
    });
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

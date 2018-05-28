<?php

namespace TrainjunkiesPackages\NetworkRailScheduleFileParser;

use TrainjunkiesPackages\NetworkRailScheduleFileParser\Line\Tiploc;

class TiplocFactory
{
    public static function createTiplocFileParser($fileName)
    {
        return new Tiploc(
            new \SplFileObject($fileName)
        );
    }
}

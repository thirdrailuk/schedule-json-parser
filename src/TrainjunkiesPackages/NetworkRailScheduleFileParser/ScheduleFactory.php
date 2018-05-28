<?php

namespace TrainjunkiesPackages\NetworkRailScheduleFileParser;

use TrainjunkiesPackages\NetworkRailScheduleFileParser\Line\Schedule;

class ScheduleFactory
{
    public static function createScheduleFileParser($fileName)
    {
        return new Schedule(
            new \SplFileObject($fileName)
        );
    }
}

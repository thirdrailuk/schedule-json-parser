<?php

namespace TrainjunkiesPackages\NetworkRailScheduleFileParser\Line;

use TrainjunkiesPackages\NetworkRailScheduleFileParser\Line;
use TrainjunkiesPackages\NetworkRailScheduleFileParser\ParserAbstract;

class Tiploc extends ParserAbstract implements Line
{
    const STARTS_WITH = '{"TiplocV1"';

    public function startsWith()
    {
        return self::STARTS_WITH;
    }
}

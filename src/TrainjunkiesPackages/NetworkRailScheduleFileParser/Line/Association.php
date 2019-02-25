<?php

namespace TrainjunkiesPackages\NetworkRailScheduleFileParser\Line;

use TrainjunkiesPackages\NetworkRailScheduleFileParser\Line;
use TrainjunkiesPackages\NetworkRailScheduleFileParser\ParserAbstract;

class Association extends ParserAbstract implements Line
{
    const STARTS_WITH = '{"JsonAssociationV1"';

    public function startsWith()
    {
        return self::STARTS_WITH;
    }
}

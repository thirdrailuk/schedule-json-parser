<?php

namespace TrainjunkiesPackages\NetworkRailScheduleFileParser;

interface Line
{
    public function get(callable $function);
    public function startsWith();
}

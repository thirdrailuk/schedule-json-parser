<?php

namespace TrainjunkiesPackages\ScheduleJsonParser;

class Factory
{
    public static function create(string $jsonFilePath): Parser
    {
        return Parser::fromJsonFile(
            new \SplFileObject($jsonFilePath)
        );
    }
}

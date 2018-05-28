<?php

namespace TrainjunkiesPackages\NetworkRailScheduleFileParser;

use TrainjunkiesPackages\NetworkRailScheduleFileParser\Line\Association;

class AssociationFactory
{
    public static function createAssociationFileParser($fileName)
    {
        return new Association(
            new \SplFileObject($fileName)
        );
    }
}

<?php

namespace TrainjunkiesPackages\ScheduleJsonParser;

class JsonException extends \Exception
{
    public static function fromJsonErrorMessage(): self
    {
        return new self(json_last_error_msg(), json_last_error());
    }
}

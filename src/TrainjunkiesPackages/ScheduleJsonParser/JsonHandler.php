<?php

namespace TrainjunkiesPackages\ScheduleJsonParser;

class JsonHandler
{
    /**
     * @param mixed $value
     * @param int   $options
     *
     * @return string
     * @throws JsonException
     */
    public static function encode($value, $options = 0): string
    {
        /** @var string|false $result */
        $result = json_encode($value, $options);

        if (json_last_error() === JSON_ERROR_NONE) {
            return (string)$result;
        }

        throw JsonException::fromJsonErrorMessage();
    }

    /**
     * @param string $json
     * @param bool   $assoc
     * @param int    $depth
     * @param int    $options
     *
     * @return mixed
     * @throws JsonException
     */
    public static function decode(string $json, $assoc = false, $depth = 512, $options = 0)
    {
        /** @var string|false $result */
        $result = json_decode($json, $assoc, $depth, $options);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }

        throw JsonException::fromJsonErrorMessage();
    }
}

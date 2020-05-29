<?php

namespace spec\TrainjunkiesPackages\ScheduleJsonParser;

use PhpSpec\ObjectBehavior;
use TrainjunkiesPackages\ScheduleJsonParser\JsonException;
use TrainjunkiesPackages\ScheduleJsonParser\JsonHandler;

class JsonHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonHandler::class);
    }

    function it_can_encode_valid_json()
    {
        $data = ['one', 'two', 'three'];
        $json = '["one","two","three"]';

        $this::encode($data)->shouldBe($json);
    }

    function it_should_throw_exception_decoding_invalid_json()
    {
        $json = '["one","two","three]]]}';
        $this->shouldThrow(JsonException::class)->duringDecode($json);
    }

    function it_can_decode_valid_json()
    {
        $json = '["one","two","three"]';
        $data = ['one', 'two', 'three'];

        $this::decode($json)->shouldBe($data);
    }
}

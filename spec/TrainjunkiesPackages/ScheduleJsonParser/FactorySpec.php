<?php

namespace spec\TrainjunkiesPackages\ScheduleJsonParser;

use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use TrainjunkiesPackages\ScheduleJsonParser\Factory;
use TrainjunkiesPackages\ScheduleJsonParser\Parser;

class FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_can_create_json_parser()
    {
        vfsStream::setup(
            'root',
            null,
            [
                'json-file' => ''
            ]
        );

        $this::create(
            vfsStream::url('root/json-file')
        )->shouldBeAnInstanceOf(Parser::class);
    }
}

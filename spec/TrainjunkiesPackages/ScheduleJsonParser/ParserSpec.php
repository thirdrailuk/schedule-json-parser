<?php

namespace spec\TrainjunkiesPackages\ScheduleJsonParser;

use PHPUnit\Framework\Assert;
use TrainjunkiesPackages\ScheduleJsonParser\Parser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserSpec extends ObjectBehavior
{
    const JSON_TIMETABLE = '{"JsonTimetableV1":{"classification":"public","timestamp":1506381255,"owner":"Network Rail","Sender":{"organisation":"Rockshore","application":"NTROD","component":"SCHEDULE"},"Metadata":{"type":"full","sequence":1930}}}';
    const TIPLOC_L1 = '{"TiplocV1":{"transaction_type":"Create","tiploc_code":"ABCWM","nalco":"385964","stanox":"78128","crs_code":null,"description":null,"tps_description":"ABERCWMBOI"}}';
    const TIPLOC_L2 = '{"TiplocV1":{"transaction_type":"Create","tiploc_code":"ABDAPEN","nalco":"398202","stanox":null,"crs_code":"XPZ","description":null,"tps_description":"PENYWAUN BUS"}}';
    const TIPLOC_L3 = '{"TiplocV1":{"transaction_type":"Create","tiploc_code":"ABDARE","nalco":"398200","stanox":"78100","crs_code":"ABA","description":"ABERDARE","tps_description":"ABERDARE"}}';
    const TIPLOC_L4 = '{"TiplocV1":{"transaction_type":"Create","tiploc_code":"ABDATRE","nalco":"398203","stanox":null,"crs_code":"XTO","description":null,"tps_description":"TRECYNON BUS"}}';
    const ASSOCIATION_L1 = '{"JsonAssociationV1":{"transaction_type":"Create","main_train_uid":"P51449","assoc_train_uid":"P52404","assoc_start_date":"2017-05-27T00:00:00Z","assoc_end_date":"2017-12-09T00:00:00Z","assoc_days":"0000010","category":"JJ","date_indicator":"S","location":"BHAMNWS","base_location_suffix":null,"assoc_location_suffix":null,"diagram_type":"T","CIF_stp_indicator":"P"}}';
    const ASSOCIATION_L2 = '{"JsonAssociationV1":{"transaction_type":"Create","main_train_uid":"P51831","assoc_train_uid":"P51769","assoc_start_date":"2017-10-01T00:00:00Z","assoc_end_date":"2017-10-01T00:00:00Z","assoc_days":"0000001","category":"NP","date_indicator":"S","location":"GLGC","base_location_suffix":null,"assoc_location_suffix":null,"diagram_type":"T","CIF_stp_indicator":"O"}}';
    const SCHEDULE_L1 = '{"JsonScheduleV1":{"CIF_bank_holiday_running":null,"CIF_stp_indicator":"O","CIF_train_uid":"P51984","applicable_timetable":"Y","atoc_code":"VT","new_schedule_segment":{"traction_class":"","uic_code":""},"schedule_days_runs":"0000010","schedule_end_date":"2017-11-11","schedule_segment":{"signalling_id":"5B46","CIF_train_category":"EE","CIF_headcode":"","CIF_course_indicator":1,"CIF_train_service_code":"22112002","CIF_business_sector":"??","CIF_power_type":"EMU","CIF_timing_load":"390","CIF_speed":"125","CIF_operating_characteristics":null,"CIF_train_class":null,"CIF_sleepers":null,"CIF_reservations":null,"CIF_connection_indicator":null,"CIF_catering_code":null,"CIF_service_branding":"","schedule_location":[{"location_type":"LO","record_identity":"LO","tiploc_code":"EUSTON","tiploc_instance":null,"departure":"0130","public_departure":null,"platform":"6","line":"C","engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CMDNSTH","tiploc_instance":null,"arrival":null,"departure":null,"pass":"0132H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CMDNJN","tiploc_instance":null,"arrival":null,"departure":null,"pass":"0133","public_arrival":null,"public_departure":null,"platform":null,"line":"SL","path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDWLJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"0136","public_arrival":null,"public_departure":null,"platform":null,"line":"DR","path":"SL","engineering_allowance":null,"pathing_allowance":"1","performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDNN7","tiploc_instance":null,"arrival":null,"departure":null,"pass":"0138H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDBSJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"0140H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDNBJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"0142H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSD31","tiploc_instance":null,"arrival":null,"departure":null,"pass":"0145H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WMBY","tiploc_instance":null,"arrival":"0149","departure":"0204","pass":null,"public_arrival":null,"public_departure":null,"platform":null,"line":"CL","path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LT","record_identity":"LT","tiploc_code":"WMBYICD","tiploc_instance":null,"arrival":"0214","public_arrival":null,"platform":null,"path":null}]},"schedule_start_date":"2017-11-11","train_status":"P","transaction_type":"Create"}}';
    const SCHEDULE_L2 = '{"JsonScheduleV1":{"CIF_bank_holiday_running":null,"CIF_stp_indicator":"O","CIF_train_uid":"P52193","applicable_timetable":"Y","atoc_code":"VT","new_schedule_segment":{"traction_class":"","uic_code":""},"schedule_days_runs":"0000010","schedule_end_date":"2017-11-11","schedule_segment":{"signalling_id":"5M15","CIF_train_category":"EE","CIF_headcode":"","CIF_course_indicator":1,"CIF_train_service_code":"22112002","CIF_business_sector":"??","CIF_power_type":"EMU","CIF_timing_load":"390","CIF_speed":"125","CIF_operating_characteristics":null,"CIF_train_class":null,"CIF_sleepers":null,"CIF_reservations":null,"CIF_connection_indicator":null,"CIF_catering_code":null,"CIF_service_branding":"","schedule_location":[{"location_type":"LO","record_identity":"LO","tiploc_code":"EUSTON","tiploc_instance":null,"departure":"2006","public_departure":null,"platform":"13","line":"C","engineering_allowance":null,"pathing_allowance":"H","performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CMDNSTH","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2009","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CMDNJN","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2009H","public_arrival":null,"public_departure":null,"platform":null,"line":"SL","path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDWLJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2012H","public_arrival":null,"public_departure":null,"platform":null,"line":"DR","path":"SL","engineering_allowance":null,"pathing_allowance":"H","performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDNN7","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2014H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDBSJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2016H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDNBJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2017H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSD31","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2020H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WMBY","tiploc_instance":null,"arrival":"2024","departure":"2039","pass":null,"public_arrival":null,"public_departure":null,"platform":null,"line":"CL","path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LT","record_identity":"LT","tiploc_code":"WMBYICD","tiploc_instance":null,"arrival":"2049","public_arrival":null,"platform":null,"path":null}]},"schedule_start_date":"2017-11-11","train_status":"P","transaction_type":"Create"}}';
    const SCHEDULE_L3 = '{"JsonScheduleV1":{"CIF_bank_holiday_running":null,"CIF_stp_indicator":"O","CIF_train_uid":"P52194","applicable_timetable":"Y","atoc_code":"VT","new_schedule_segment":{"traction_class":"","uic_code":""},"schedule_days_runs":"0000010","schedule_end_date":"2017-11-11","schedule_segment":{"signalling_id":"5M16","CIF_train_category":"EE","CIF_headcode":"","CIF_course_indicator":1,"CIF_train_service_code":"22112002","CIF_business_sector":"??","CIF_power_type":"EMU","CIF_timing_load":"390","CIF_speed":"125","CIF_operating_characteristics":null,"CIF_train_class":null,"CIF_sleepers":null,"CIF_reservations":null,"CIF_connection_indicator":null,"CIF_catering_code":null,"CIF_service_branding":"","schedule_location":[{"location_type":"LO","record_identity":"LO","tiploc_code":"EUSTON","tiploc_instance":null,"departure":"2046","public_departure":null,"platform":"5","line":"C","engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CMDNSTH","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2048H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CMDNJN","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2049","public_arrival":null,"public_departure":null,"platform":null,"line":"SL","path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDWLJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2052","public_arrival":null,"public_departure":null,"platform":null,"line":"DR","path":"SL","engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDNN7","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2053H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDBSJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2055H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSDNBJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2057H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WLSD31","tiploc_instance":null,"arrival":null,"departure":null,"pass":"2100H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WMBY","tiploc_instance":null,"arrival":"2104","departure":"2119","pass":null,"public_arrival":null,"public_departure":null,"platform":null,"line":"CL","path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LT","record_identity":"LT","tiploc_code":"WMBYICD","tiploc_instance":null,"arrival":"2129","public_arrival":null,"platform":null,"path":null}]},"schedule_start_date":"2017-11-11","train_status":"P","transaction_type":"Create"}}';

    function let(\SplFileObject $splFileObject)
    {
        $lines = $this->scheduleFileContent();

        $splFileObject->fgets()->willReturn(
            $lines[0],
            $lines[1],
            $lines[2],
            $lines[3],
            $lines[4],
            $lines[5],
            $lines[6],
            $lines[7],
            $lines[8],
            $lines[9],
            $lines[10]
        );

        $splFileObject->eof()->willReturn(
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            true
        );

        $splFileObject->beConstructedWith(['/root/var/file']);

        $this->beConstructedWith($splFileObject);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Parser::class);
    }

    function it_can_parse_contents()
    {
        $meta = function($string) {
            Assert::assertEquals(self::JSON_TIMETABLE, $string);
        };

        $tiploc = function ($string) {
            Assert::assertContains(
                $string,
                [
                    self::TIPLOC_L1,
                    self::TIPLOC_L2,
                    self::TIPLOC_L3,
                    self::TIPLOC_L4
                ]
            );
        };

        $association = function ($string) {
            Assert::assertContains(
                $string,
                [
                   self::ASSOCIATION_L1,
                   self::ASSOCIATION_L2
                ]
            );
        };

        $schedule = function ($string) {
            Assert::assertContains(
                $string,
                [
                    self::SCHEDULE_L1,
                    self::SCHEDULE_L2,
                    self::SCHEDULE_L3
                ]
            );
        };

        $this->parse($meta, $tiploc, $association, $schedule);
    }

    private function scheduleFileContent()
    {
        return [
            self::JSON_TIMETABLE,
            self::TIPLOC_L1,
            self::TIPLOC_L2,
            self::TIPLOC_L3,
            self::TIPLOC_L4,
            self::ASSOCIATION_L1,
            self::ASSOCIATION_L2,
            self::SCHEDULE_L1,
            self::SCHEDULE_L2,
            self::SCHEDULE_L3,
            '{"EOF":true}'
        ];
    }
}

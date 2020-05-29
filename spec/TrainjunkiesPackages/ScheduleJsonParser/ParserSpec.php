<?php

namespace spec\TrainjunkiesPackages\ScheduleJsonParser;

use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

class ParserSpec extends ObjectBehavior
{
    function let()
    {
        vfsStream::setup(
            'root',
            null,
            [
                'json-file' => $this->jsonFileContents()
            ]
        );

        $this->beConstructedFromJsonFile(
            new \SplFileObject(vfsStream::url('root/json-file'))
        );
    }

    function it_can_parse_meta()
    {
        $results = [];

        $callback = function($data) use(&$results) {
            $results[] = $data;
        };

        $this->parse(
            $callback,
            function($data) {},
            function($data) {},
            function($data) {}
        );

        Assert::eq($results[0]['JsonTimetableV1']['owner'], 'Network Rail');
        Assert::eq($results[0]['JsonTimetableV1']['timestamp'], 1590707228);
        Assert::eq($results[0]['JsonTimetableV1']['Metadata']['type'], 'full');
        Assert::eq($results[0]['JsonTimetableV1']['Metadata']['sequence'], 2906);
    }

    function it_can_parse_tiplocs()
    {
        $results = [];

        $callback = function($data) use(&$results) {
            $results[] = $data;
        };

        $this->parse(
            function($data) {},
            $callback,
            function($data) {},
            function($data) {}
        );

        Assert::count($results, 4);

        Assert::eq($results[0]['TiplocV1']['transaction_type'], 'Create');
        Assert::eq($results[0]['TiplocV1']['tiploc_code'], 'PTWYPR');
        Assert::eq($results[0]['TiplocV1']['tps_description'], 'PORTWAY PARK AND RIDE');

        Assert::eq($results[1]['TiplocV1']['transaction_type'], 'Create');
        Assert::eq($results[1]['TiplocV1']['tiploc_code'], 'REDH305');
        Assert::eq($results[1]['TiplocV1']['tps_description'], 'REDHILL SIGNAL T1305');

        Assert::eq($results[2]['TiplocV1']['transaction_type'], 'Create');
        Assert::eq($results[2]['TiplocV1']['tiploc_code'], 'REDH308');
        Assert::eq($results[2]['TiplocV1']['tps_description'], 'REDHILL SIGNAL T1308');

        Assert::eq($results[3]['TiplocV1']['transaction_type'], 'Create');
        Assert::eq($results[3]['TiplocV1']['tiploc_code'], 'REDH320');
        Assert::eq($results[3]['TiplocV1']['tps_description'], 'REDHILL SIGNAL T1320');
    }

    function it_can_parse_associations()
    {
        $results = [];

        $callback = function($data) use(&$results) {
            $results[] = $data;
        };

        $this->parse(
            function($data) {},
            function($data) {},
            $callback,
            function($data) {}
        );

        Assert::count($results, 4);

        Assert::eq($results[0]['JsonAssociationV1']['transaction_type'], 'Delete');
        Assert::eq($results[0]['JsonAssociationV1']['main_train_uid'], 'C38722');
        Assert::eq($results[0]['JsonAssociationV1']['assoc_train_uid'], 'C38284');

        Assert::eq($results[1]['JsonAssociationV1']['transaction_type'], 'Delete');
        Assert::eq($results[1]['JsonAssociationV1']['main_train_uid'], 'C38719');
        Assert::eq($results[1]['JsonAssociationV1']['assoc_train_uid'], 'C38408');

        Assert::eq($results[2]['JsonAssociationV1']['transaction_type'], 'Delete');
        Assert::eq($results[2]['JsonAssociationV1']['main_train_uid'], 'C38717');
        Assert::eq($results[2]['JsonAssociationV1']['assoc_train_uid'], 'C38405');

        Assert::eq($results[3]['JsonAssociationV1']['transaction_type'], 'Delete');
        Assert::eq($results[3]['JsonAssociationV1']['main_train_uid'], 'W61007');
        Assert::eq($results[3]['JsonAssociationV1']['assoc_train_uid'], 'P95750');
    }

    function it_can_parse_schedules()
    {
        $results = [];

        $callback = function($data) use(&$results) {
            $results[] = $data;
        };

        $this->parse(
            function($data) {},
            function($data) {},
            function($data) {},
            $callback
        );

        Assert::count($results, 7);

        Assert::eq($results[0]['JsonScheduleV1']['transaction_type'], 'Delete');
        Assert::eq($results[0]['JsonScheduleV1']['CIF_train_uid'], 'C86643');
        Assert::eq($results[0]['JsonScheduleV1']['schedule_start_date'], '2020-09-20');
        Assert::eq($results[0]['JsonScheduleV1']['CIF_stp_indicator'], 'P');

        Assert::eq($results[3]['JsonScheduleV1']['transaction_type'], 'Delete');
        Assert::eq($results[3]['JsonScheduleV1']['CIF_train_uid'], 'C86905');
        Assert::eq($results[3]['JsonScheduleV1']['schedule_start_date'], '2020-09-20');
        Assert::eq($results[3]['JsonScheduleV1']['CIF_stp_indicator'], 'P');

        Assert::eq($results[4]['JsonScheduleV1']['transaction_type'], 'Create');
        Assert::eq($results[4]['JsonScheduleV1']['CIF_train_uid'], 'C95113');
        Assert::eq($results[4]['JsonScheduleV1']['schedule_start_date'], '2020-08-08');
        Assert::eq($results[4]['JsonScheduleV1']['CIF_stp_indicator'], 'O');

        Assert::eq($results[6]['JsonScheduleV1']['transaction_type'], 'Create');
        Assert::eq($results[6]['JsonScheduleV1']['CIF_train_uid'], 'C95081');
        Assert::eq($results[6]['JsonScheduleV1']['schedule_start_date'], '2020-08-08');
        Assert::eq($results[6]['JsonScheduleV1']['CIF_stp_indicator'], 'O');
    }

    private function jsonFileContents()
    {
        return <<<STRING
{"JsonTimetableV1":{"classification":"public","timestamp":1590707228,"owner":"Network Rail","Sender":{"organisation":"Rockshore","application":"NTROD","component":"SCHEDULE"},"Metadata":{"type":"full","sequence":2906}}}
{"JsonAssociationV1":{"transaction_type":"Delete","main_train_uid":"C38722","assoc_train_uid":"C38284","assoc_start_date":"2020-05-18T00:00:00Z","location":"BARRYIS","base_location_suffix":null,"diagram_type":"T","CIF_stp_indicator":"C"}}
{"JsonAssociationV1":{"transaction_type":"Delete","main_train_uid":"C38719","assoc_train_uid":"C38408","assoc_start_date":"2020-05-18T00:00:00Z","location":"BARRYIS","base_location_suffix":null,"diagram_type":"T","CIF_stp_indicator":"C"}}
{"JsonAssociationV1":{"transaction_type":"Delete","main_train_uid":"C38717","assoc_train_uid":"C38405","assoc_start_date":"2020-05-18T00:00:00Z","location":"BARRYIS","base_location_suffix":null,"diagram_type":"T","CIF_stp_indicator":"C"}}
{"JsonAssociationV1":{"transaction_type":"Delete","main_train_uid":"W61007","assoc_train_uid":"P95750","assoc_start_date":"2020-06-07T00:00:00Z","location":"RAMSGTE","base_location_suffix":null,"diagram_type":"T","CIF_stp_indicator":"C"}}
{"TiplocV1":{"transaction_type":"Create","tiploc_code":"PTWYPR","nalco":"112300","stanox":"81246","crs_code":null,"description":null,"tps_description":"PORTWAY PARK AND RIDE"}}
{"TiplocV1":{"transaction_type":"Create","tiploc_code":"REDH305","nalco":"547801","stanox":"87732","crs_code":null,"description":null,"tps_description":"REDHILL SIGNAL T1305"}}
{"TiplocV1":{"transaction_type":"Create","tiploc_code":"REDH308","nalco":"547812","stanox":"87730","crs_code":null,"description":null,"tps_description":"REDHILL SIGNAL T1308"}}
{"TiplocV1":{"transaction_type":"Create","tiploc_code":"REDH320","nalco":"547817","stanox":"87729","crs_code":null,"description":null,"tps_description":"REDHILL SIGNAL T1320"}}
{"JsonScheduleV1":{"CIF_train_uid":"C86643","schedule_start_date":"2020-09-20","CIF_stp_indicator":"P","transaction_type":"Delete"}}
{"JsonScheduleV1":{"CIF_train_uid":"C86647","schedule_start_date":"2020-09-20","CIF_stp_indicator":"P","transaction_type":"Delete"}}
{"JsonScheduleV1":{"CIF_train_uid":"C86771","schedule_start_date":"2020-09-20","CIF_stp_indicator":"P","transaction_type":"Delete"}}
{"JsonScheduleV1":{"CIF_train_uid":"C86905","schedule_start_date":"2020-09-20","CIF_stp_indicator":"P","transaction_type":"Delete"}}
{"JsonScheduleV1":{"CIF_bank_holiday_running":null,"CIF_stp_indicator":"O","CIF_train_uid":"C95113","applicable_timetable":"Y","atoc_code":"LO","new_schedule_segment":{"traction_class":"","uic_code":""},"schedule_days_runs":"0000010","schedule_end_date":"2020-08-08","schedule_segment":{"signalling_id":"9A30","CIF_train_category":"OO","CIF_headcode":"","CIF_course_indicator":1,"CIF_train_service_code":"22215003","CIF_business_sector":"??","CIF_power_type":"EMU","CIF_timing_load":"378","CIF_speed":"075","CIF_operating_characteristics":"D","CIF_train_class":"S","CIF_sleepers":null,"CIF_reservations":null,"CIF_connection_indicator":null,"CIF_catering_code":null,"CIF_service_branding":"","schedule_location":[{"location_type":"LO","record_identity":"LO","tiploc_code":"HIGHBYE","tiploc_instance":null,"departure":"1240","public_departure":"1240","platform":"1","line":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CNNBELL","tiploc_instance":null,"arrival":"1241H","departure":"1242","pass":null,"public_arrival":"1242","public_departure":"1242","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"DALS","tiploc_instance":null,"arrival":"1244","departure":"1245H","pass":null,"public_arrival":"1244","public_departure":"1245","platform":"4","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"HAGGERS","tiploc_instance":null,"arrival":"1247","departure":"1247H","pass":null,"public_arrival":"1247","public_departure":"1247","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"HOXTON","tiploc_instance":null,"arrival":"1249","departure":"1249H","pass":null,"public_arrival":"1249","public_departure":"1249","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SHRDHST","tiploc_instance":null,"arrival":"1251H","departure":"1252","pass":null,"public_arrival":"1252","public_departure":"1252","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WCHAPEL","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1254","public_arrival":null,"public_departure":null,"platform":"6","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SHADWEL","tiploc_instance":null,"arrival":"1256","departure":"1256H","pass":null,"public_arrival":"1256","public_departure":"1256","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WAPPING","tiploc_instance":null,"arrival":"1258","departure":"1258H","pass":null,"public_arrival":"1258","public_departure":"1258","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"RTHERHI","tiploc_instance":null,"arrival":"1259H","departure":"1300","pass":null,"public_arrival":"1300","public_departure":"1300","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CNDAW","tiploc_instance":null,"arrival":"1301","departure":"1302","pass":null,"public_arrival":"1301","public_departure":"1302","platform":"3","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SURREYQ","tiploc_instance":null,"arrival":"1303","departure":"1304","pass":null,"public_arrival":"1303","public_departure":"1304","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SURRQSJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1304H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CANALJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1305H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"NEWXNJN","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1306H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"NEWXGEL","tiploc_instance":null,"arrival":"1307H","departure":"1308H","pass":null,"public_arrival":"1308","public_departure":"1308","platform":"1","line":"SL","path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"BROCKLY","tiploc_instance":null,"arrival":"1310H","departure":"1311","pass":null,"public_arrival":"1311","public_departure":"1311","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"HONROPK","tiploc_instance":null,"arrival":"1313","departure":"1313H","pass":null,"public_arrival":"1313","public_departure":"1313","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"FORESTH","tiploc_instance":null,"arrival":"1315H","departure":"1316","pass":null,"public_arrival":"1316","public_departure":"1316","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SYDENHM","tiploc_instance":null,"arrival":"1318H","departure":"1319","pass":null,"public_arrival":"1319","public_departure":"1319","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LT","record_identity":"LT","tiploc_code":"CRYSTLP","tiploc_instance":null,"arrival":"1323","public_arrival":"1328","platform":"5","path":null}]},"schedule_start_date":"2020-08-08","train_status":"P","transaction_type":"Create"}}
{"JsonScheduleV1":{"CIF_bank_holiday_running":null,"CIF_stp_indicator":"O","CIF_train_uid":"C96117","applicable_timetable":"Y","atoc_code":"LO","new_schedule_segment":{"traction_class":"","uic_code":""},"schedule_days_runs":"0000010","schedule_end_date":"2020-08-08","schedule_segment":{"signalling_id":"9F25","CIF_train_category":"OO","CIF_headcode":"","CIF_course_indicator":1,"CIF_train_service_code":"22218000","CIF_business_sector":"??","CIF_power_type":"EMU","CIF_timing_load":"378","CIF_speed":"075","CIF_operating_characteristics":"D","CIF_train_class":"S","CIF_sleepers":null,"CIF_reservations":null,"CIF_connection_indicator":null,"CIF_catering_code":null,"CIF_service_branding":"","schedule_location":[{"location_type":"LO","record_identity":"LO","tiploc_code":"NWCRELL","tiploc_instance":null,"departure":"1157","public_departure":"1157","platform":"D","line":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"ROLTSTJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1158","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CANALJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1159","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SURRQSJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1200","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SURREYQ","tiploc_instance":null,"arrival":"1200H","departure":"1201H","pass":null,"public_arrival":"1201","public_departure":"1201","platform":"1","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CNDAW","tiploc_instance":null,"arrival":"1202H","departure":"1203H","pass":null,"public_arrival":"1203","public_departure":"1203","platform":"4","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"RTHERHI","tiploc_instance":null,"arrival":"1204H","departure":"1205","pass":null,"public_arrival":"1205","public_departure":"1205","platform":"1","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WAPPING","tiploc_instance":null,"arrival":"1206","departure":"1206H","pass":null,"public_arrival":"1206","public_departure":"1206","platform":"1","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SHADWEL","tiploc_instance":null,"arrival":"1208","departure":"1208H","pass":null,"public_arrival":"1208","public_departure":"1208","platform":"1","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WCHAPEL","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1210H","public_arrival":null,"public_departure":null,"platform":"5","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SHRDHST","tiploc_instance":null,"arrival":"1212H","departure":"1213H","pass":null,"public_arrival":"1213","public_departure":"1213","platform":"1","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"HOXTON","tiploc_instance":null,"arrival":"1215","departure":"1215H","pass":null,"public_arrival":"1215","public_departure":"1215","platform":"1","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"HAGGERS","tiploc_instance":null,"arrival":"1217","departure":"1217H","pass":null,"public_arrival":"1217","public_departure":"1217","platform":"1","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LT","record_identity":"LT","tiploc_code":"DALS","tiploc_instance":null,"arrival":"1219","public_arrival":"1224","platform":"2","path":null}]},"schedule_start_date":"2020-08-08","train_status":"P","transaction_type":"Create"}}
{"JsonScheduleV1":{"CIF_bank_holiday_running":null,"CIF_stp_indicator":"O","CIF_train_uid":"C95081","applicable_timetable":"Y","atoc_code":"LO","new_schedule_segment":{"traction_class":"","uic_code":""},"schedule_days_runs":"0000010","schedule_end_date":"2020-08-08","schedule_segment":{"signalling_id":"9A18","CIF_train_category":"OO","CIF_headcode":"","CIF_course_indicator":1,"CIF_train_service_code":"22215003","CIF_business_sector":"??","CIF_power_type":"EMU","CIF_timing_load":"378","CIF_speed":"075","CIF_operating_characteristics":"D","CIF_train_class":"S","CIF_sleepers":null,"CIF_reservations":null,"CIF_connection_indicator":null,"CIF_catering_code":null,"CIF_service_branding":"","schedule_location":[{"location_type":"LO","record_identity":"LO","tiploc_code":"HIGHBYE","tiploc_instance":null,"departure":"0940","public_departure":"0940","platform":"1","line":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CNNBELL","tiploc_instance":null,"arrival":"0941H","departure":"0942","pass":null,"public_arrival":"0942","public_departure":"0942","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"DALS","tiploc_instance":null,"arrival":"0944","departure":"0945H","pass":null,"public_arrival":"0944","public_departure":"0945","platform":"4","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"HAGGERS","tiploc_instance":null,"arrival":"0947","departure":"0947H","pass":null,"public_arrival":"0947","public_departure":"0947","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"HOXTON","tiploc_instance":null,"arrival":"0949","departure":"0949H","pass":null,"public_arrival":"0949","public_departure":"0949","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SHRDHST","tiploc_instance":null,"arrival":"0951H","departure":"0952","pass":null,"public_arrival":"0952","public_departure":"0952","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WCHAPEL","tiploc_instance":null,"arrival":null,"departure":null,"pass":"0954","public_arrival":null,"public_departure":null,"platform":"6","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SHADWEL","tiploc_instance":null,"arrival":"0956","departure":"0956H","pass":null,"public_arrival":"0956","public_departure":"0956","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"WAPPING","tiploc_instance":null,"arrival":"0958","departure":"0958H","pass":null,"public_arrival":"0958","public_departure":"0958","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"RTHERHI","tiploc_instance":null,"arrival":"0959H","departure":"1000","pass":null,"public_arrival":"1000","public_departure":"1000","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CNDAW","tiploc_instance":null,"arrival":"1001","departure":"1002","pass":null,"public_arrival":"1001","public_departure":"1002","platform":"3","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SURREYQ","tiploc_instance":null,"arrival":"1003","departure":"1004","pass":null,"public_arrival":"1003","public_departure":"1004","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SURRQSJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1004H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"CANALJ","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1005H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"NEWXNJN","tiploc_instance":null,"arrival":null,"departure":null,"pass":"1006H","public_arrival":null,"public_departure":null,"platform":null,"line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"NEWXGEL","tiploc_instance":null,"arrival":"1007H","departure":"1008H","pass":null,"public_arrival":"1008","public_departure":"1008","platform":"1","line":"SL","path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"BROCKLY","tiploc_instance":null,"arrival":"1010H","departure":"1011","pass":null,"public_arrival":"1011","public_departure":"1011","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"HONROPK","tiploc_instance":null,"arrival":"1013","departure":"1013H","pass":null,"public_arrival":"1013","public_departure":"1013","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"FORESTH","tiploc_instance":null,"arrival":"1015H","departure":"1016","pass":null,"public_arrival":"1016","public_departure":"1016","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LI","record_identity":"LI","tiploc_code":"SYDENHM","tiploc_instance":null,"arrival":"1018H","departure":"1019","pass":null,"public_arrival":"1019","public_departure":"1019","platform":"2","line":null,"path":null,"engineering_allowance":null,"pathing_allowance":null,"performance_allowance":null},{"location_type":"LT","record_identity":"LT","tiploc_code":"CRYSTLP","tiploc_instance":null,"arrival":"1023","public_arrival":"1028","platform":"5","path":null}]},"schedule_start_date":"2020-08-08","train_status":"P","transaction_type":"Create"}}
STRING;
    }
}

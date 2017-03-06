<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Attendee.php";

    $server = 'mysql:host=localhost:8889;dbname=rsvparty_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class AttendeeTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Attendee::deleteAll();
        }

        function test_save()
        {
            $name = 'Geoff';
            $event_id = '2';
            $test_attendee = new Attendee($name, $event_id);

            $test_attendee->save();
            $result = Attendee::getAll();

            $this->assertEquals($test_attendee, $result[0]);
        }

        function test_getAll()
        {
            $name = 'Geoff';
            $event_id = '2';
            $test_attendee = new Attendee($name, $event_id);
            $test_attendee->save();

            $name = 'Dave';
            $event_id = '4';
            $test_attendee2 = new Attendee($name, $event_id);
            $test_attendee2->save();

            $result = Attendee::getAll();

            $this->assertEquals([$test_attendee, $test_attendee2], $result);
        }

        function test_deleteAll()
        {
            $name = 'Geoff';
            $event_id = '2';
            $test_attendee = new Attendee($name, $event_id);
            $test_attendee->save();

            $name = 'Dave';
            $event_id = '4';
            $test_attendee2 = new Attendee($name, $event_id);
            $test_attendee2->save();

            Attendee::deleteAll();
            $result = Attendee::getAll();

            $this->assertEquals([], $result);
        }
    }
?>

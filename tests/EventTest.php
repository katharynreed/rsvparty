<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once 'src/Event.php';

    $server = 'mysql:host=localhost:8889;dbname=rsvparty_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class EventTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Event::deleteAll();
        }

        function test_getters()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '20171010 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $id = '1';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location, $id);

            $result = array($test_event->getUserId(), $test_event->getName(), $test_event->getDateTime(), $test_event->getDescription(), $test_event->getLocation(), $test_event->getId());
            $expected_result = array('1','Sock Puppet Convention', '20171010 13:30:00', 'Soft core puppet enthusiasts.', 'Portland, OR', '1');
            $this->assertEquals($result, $expected_result);
        }

        function test_setters()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '20171010 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $id = '1';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location, $id);

            $test_event->setName('Sock Puppet Annual Event');
            $test_event->setDescription('Soft core puppet enthusiasts -- no weird stuff.');
            $test_event->setLocation('Gresham, OR');

            $result = array($test_event->getName(), $test_event->getDescription(), $test_event->getLocation());
            $expected_result = array('Sock Puppet Annual Event', 'Soft core puppet enthusiasts -- no weird stuff.', 'Gresham, OR');
            $this->assertEquals($result, $expected_result);
        }

    }

?>

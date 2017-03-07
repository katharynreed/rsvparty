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
            Attendee::deleteAll();
            Task::deleteAll();
            User::deleteAll();
        }

        function test_save()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);

            $test_event->save();

            $result = Event::getAll();

            $this->assertEquals($test_event, $result[0]);
        }

        function test_getAll()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);
            $test_event->save();

            $user_id2 = '2';
            $name2 = 'Sausage Convention';
            $date_time2 = '2017-12-10 13:30:00';
            $description2 = 'For CULINARY sausage enthusiasts.';
            $location2 = 'Portland, OR';
            $test_event2 = new Event ($user_id2, $name2, $date_time2, $description2, $location2);
            $test_event2->save();

            $result = Event::getAll();

            $this->assertEquals([$test_event, $test_event2], $result);
        }

        function test_find()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);
            $test_event->save();

            $user_id2 = '2';
            $name2 = 'Sausage Convention';
            $date_time2 = '2017-12-10 13:30:00';
            $description2 = 'For CULINARY sausage enthusiasts.';
            $location2 = 'Portland, OR';
            $test_event2 = new Event ($user_id2, $name2, $date_time2, $description2, $location2);
            $test_event2->save();

            $result = Event::find($test_event->getId());

            $this->assertEquals($test_event, $result);
        }

        function test_updateName()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);
            $test_event->save();

            $new_name = 'Sock Puppet Speed Dating';
            $test_event->updateName($new_name);

            $result = $test_event->getName();

            $this->assertEquals($new_name, $result);
        }

        function test_updateDescription()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);
            $test_event->save();

            $new_description = 'Serious puppeteers only!';
            $test_event->updateDescription($new_description);

            $result = $test_event->getDescription();

            $this->assertEquals($new_description, $result);
        }

        function test_updateLocation()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);
            $test_event->save();

            $new_location = 'Serious puppeteers only!';
            $test_event->updateLocation($new_location);

            $result = $test_event->getLocation();

            $this->assertEquals($new_location, $result);
        }

        function test_updateDateTime()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);
            $test_event->save();

            $new_date_time = '2017-09-10 13:30:00';
            $test_event->updateDateTime($new_date_time);

            $result = $test_event->getDateTime();

            $this->assertEquals($new_date_time, $result);
        }

        function test_delete()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);
            $test_event->save();

            $user_id2 = '2';
            $name2 = 'Sausage Convention';
            $date_time2 = '2017-12-10 13:30:00';
            $description2 = 'For CULINARY sausage enthusiasts.';
            $location2 = 'Portland, OR';
            $test_event2 = new Event ($user_id2, $name2, $date_time2, $description2, $location2);
            $test_event2->save();

            $test_event->delete();
            $result = Event::getAll();

            $this->assertEquals([$test_event2], $result);
        }

        function test_findByKey()
        {
            $user_id = '1';
            $name = 'Sock Puppet Convention';
            $date_time = '2017-10-10 13:30:00';
            $description = 'Soft core puppet enthusiasts.';
            $location = 'Portland, OR';
            $test_event = new Event ($user_id, $name, $date_time, $description, $location);
            $test_event->save();

            $user_id2 = '2';
            $name2 = 'Sausage Convention';
            $date_time2 = '2017-12-10 13:30:00';
            $description2 = 'For CULINARY sausage enthusiasts.';
            $location2 = 'Portland, OR';
            $test_event2 = new Event ($user_id2, $name2, $date_time2, $description2, $location2);
            $test_event2->save();
            $guest_key = $test_event->getGuestKey();
            $result = Event::findByKey($guest_key);

            $this->assertEquals($test_event, $result);

        }
    }

?>

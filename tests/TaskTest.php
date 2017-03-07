<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Task.php";
    require_once "src/Attendee.php";

    $server = 'mysql:host=localhost:8889;dbname=rsvparty_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class TaskTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Event::deleteAll();
            Attendee::deleteAll();
            Task::deleteAll();
            User::deleteAll();
        }

        function test_save() {

            $name = 'task';
            $description = 'things';
            $event_id = '4';
            $new_task = new Task($name, $description, $event_id);

            $new_task->save();
            $result = Task::getAll();

            $this->assertEquals($new_task, $result[0]);
        }

        function test_getAll()
        {
            $name = 'task';
            $description = 'things';
            $event_id = '4';
            $new_task = new Task($name, $description, $event_id);
            $new_task->save();

            $name2 = 'task';
            $description2 = 'things';
            $event_id2 = '4';
            $new_task2 = new Task($name2, $description2, $event_id2);
            $new_task2->save();

            $result = Task::getAll();

            $this->assertEquals([$new_task, $new_task2], $result);
        }

        function test_deleteAll()
        {
            $name = 'task';
            $description = 'things';
            $event_id = '4';
            $new_task = new Task($name, $description, $event_id);
            $new_task->save();

            $name2 = 'task';
            $description2 = 'things';
            $event_id2 = '4';
            $new_task2 = new Task($name2, $description2, $event_id2);
            $new_task2->save();

            Task::deleteAll();
            $result = Task::getAll();

            $this->assertEquals([], $result);
        }

        function test_update()
        {
            $name = 'task';
            $description = 'things';
            $event_id = '4';
            $new_task = new Task($name, $description, $event_id);
            $new_task->save();

            $new_name = 'new';
            $new_description = 'party';
            $new_task->update($new_name, $new_description);

            $result = Task::getAll();

            $this->assertEquals($new_name ,$result[0]->getName());
            $this->assertEquals($new_description ,$result[0]->getDescription());
        }

        function test_delete()
        {
            $name = 'task';
            $description = 'things';
            $event_id = '4';
            $new_task = new Task($name, $description, $event_id);
            $new_task->save();

            $name2 = 'task';
            $description2 = 'party';
            $event_id2 = '5';
            $new_task2 = new Task($name2, $description2, $event_id2);
            $new_task2->save();

            $new_task2->delete();
            $result = Task::getAll();

            $this->assertEquals([$new_task], $result);
        }

        function test_addAttendee()
        {
            $name = 'Geoff';
            $event_id = '2';
            $test_attendee = new Attendee($name, $event_id);
            $test_attendee->save();

            $name = 'task';
            $description = 'things';
            $event_id = '4';
            $test_task = new Task($name, $description, $event_id);
            $test_task->save();

            $test_task->addAttendee($test_attendee->getId());
            $result = $test_task->getAttendees();

            $this->assertEquals([$test_attendee], $result);
        }

        function test_getAttendees()
        {
            $name = 'Geoff';
            $event_id = '2';
            $test_attendee = new Attendee($name, $event_id);
            $test_attendee->save();

            $name = 'Joe';
            $event_id = '5';
            $test_attendee2 = new Attendee($name, $event_id);
            $test_attendee2->save();

            $name = 'task';
            $description = 'things';
            $event_id = '4';
            $test_task = new Task($name, $description, $event_id);
            $test_task->save();


            $test_task->addAttendee($test_attendee->getId());
            $test_task->addAttendee($test_attendee2->getId());

            $result = $test_task->getAttendees();

            $this->assertEquals([$test_attendee, $test_attendee2], $result);
        }
    }
?>

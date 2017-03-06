<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Task.php";

    $server = 'mysql:host=localhost:8889;dbname=rsvparty_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class TaskTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Task::deleteAll();
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
    }
?>

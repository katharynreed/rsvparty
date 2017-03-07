<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/User.php";

    $server = 'mysql:host=localhost:8889;dbname=rsvparty_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class UserTest extends PHPUnit_Framework_TestCase
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
            $name = 'Bob';
            $password = 'pass';
            $new_user = new User($name, $password);
            $new_user->save();

            $result = User::getAll();

            $this->assertEquals($new_user, $result[0]);
        }

        function test_getAll()
        {
            $name = 'Bob';
            $password = 'pass';
            $new_user = new User($name, $password);
            $new_user->save();

            $name2 = 'Bob2';
            $password2 = 'pass2';
            $new_user2 = new User($name2, $password2);
            $new_user2->save();

            $result = User::getAll();

            $this->assertEquals([$new_user, $new_user2], $result);
        }

        function test_deleteAll()
        {
            $name = 'Bob';
            $password = 'pass';
            $new_user = new User($name, $password);
            $new_user->save();

            $name2 = 'Bob2';
            $password2 = 'pass2';
            $new_user2 = new User($name2, $password2);
            $new_user2->save();

            User::deleteAll();
            $result = User::getAll();

            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = 'Bob';
            $password = 'pass';
            $new_user = new User($name, $password);
            $new_user->save();

            $name2 = 'Bob2';
            $password2 = 'pass2';
            $new_user2 = new User($name2, $password2);
            $new_user2->save();

            $result = User::find($new_user->getId());

            $this->assertEquals($new_user, $result);
        }

        function test_update()
        {
            $name = 'Bob';
            $password = 'pass';
            $new_user = new User($name, $password);
            $new_user->save();

            $new_name = 'Dave';
            $new_user->update($new_name, $password);
            $result = User::getAll();

            $this->assertEquals($new_name, $result[0]->getName());
        }

        function test_delete()
        {
            $name = 'Bob';
            $password = 'pass';
            $new_user = new User($name, $password);
            $new_user->save();

            $name2 = 'Bob2';
            $password2 = 'pass2';
            $new_user2 = new User($name2, $password2);
            $new_user2->save();

            $new_user->delete();
            $result = User::getAll();

            $this->assertEquals([$new_user2], $result);
        }
    }


?>

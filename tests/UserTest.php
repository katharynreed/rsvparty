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
            User::deleteAll();
        }

        function test_save()
        {
            $name = 'Bob';
            $password = 'pass';
            $guest_key = '2';
            $new_user = new User($name, $password, $guest_key);
            $new_user->save();

            $result = User::getAll();

            $this->assertEquals($new_user, $result[0]);
        }

        function test_getAll()
        {
            $name = 'Bob';
            $password = 'pass';
            $guest_key = '2';
            $new_user = new User($name, $password, $guest_key);
            $new_user->save();

            $name2 = 'Bob2';
            $password2 = 'pass2';
            $guest_key2 = '22';
            $new_user2 = new User($name2, $password2, $guest_key2);
            $new_user2->save();

            $result = User::getAll();

            $this->assertEquals([$new_user, $new_user2], $result);

        }

        function test_deleteAll()
        {
            $name = 'Bob';
            $password = 'pass';
            $guest_key = '2';
            $new_user = new User($name, $password, $guest_key);
            $new_user->save();

            $name2 = 'Bob2';
            $password2 = 'pass2';
            $guest_key2 = '22';
            $new_user2 = new User($name2, $password2, $guest_key2);
            $new_user2->save();

            User::deleteAll();
            $result = User::getAll();

            $this->assertEquals([], $result);
        }
    }

?>

<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    
    require_once 'src/User.php';

    $server = 'mysql:host=localhost:8889;dbname=';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {
        function test_source_function() {
            $input = ' ';
            $test_source = new Source;

            $result = $test_source->test_function();

            $this->assertEquals(1, $result);
        }
    }

?>

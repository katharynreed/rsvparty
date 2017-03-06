<?php
    class User {
        private $name;
        private $password;
        private $guest_key;
        private $id;

        function __construct($name, $password, $guest_key = null, $id = null)
        {
            $this->name = $name;
            $this->password = $password;
            $this->id = $id;
            $this->guest_key = $guest_key;
        }

        function setName($name) {
            $this->name = $name;
        }

        function getName() {
            return $this->name;
        }

        function setPassword($password) {
            $this->password = $password;
        }

        function getPassword() {
            return $this->password;
        }

        function getGuestKey() {
            return $this->guest_key;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $save = $GLOBALS['DB']->prepare("INSERT INTO users (name, password, guest_key) VALUES (:name, :password, :guest_key);");
            $save->execute([':name' => $this->getName(), ':password' => $this->getPassword(), ':guest_key' => $this->getGuestKey()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll() {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            if ($returned_users) {
                $users = $returned_users->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['name', 'password', 'guest_key', 'id']);
            } else {
                $users = [];
            }
            return $users;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec('DELETE FROM users');
        }
    }


?>

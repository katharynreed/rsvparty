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
            if ($guest_key == null) {
                $this->generateKey();
            } else {
                $this->guest_key = $guest_key;
            }
        }

        protected function generateKey()
        {
            $alph = "0123456789abcdefghijklmnopqrstuvwxyz";
            $key = $alph[mt_rand(0, 35)] . $alph[mt_rand(0, 35)] . $alph[mt_rand(0, 35)] . $alph[mt_rand(0, 35)] . $alph[mt_rand(0, 35)];
            $test = $GLOBALS['DB']->query("SELECT * FROM users WHERE guest_key = {$key};");
            if ($test) {
                $this->generateKey();
            } else {
                $this->guest_key = $key;
            }
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function getName()
        {
            return $this->name;
        }

        function setPassword($password)
        {
            $this->password = $password;
        }

        function getPassword()
        {
            return $this->password;
        }

        function getGuestKey()
        {
            return $this->guest_key;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO users (name, password, guest_key) VALUES (:name, :password, :guest_key);");
            $save->execute([':name' => $this->getName(), ':password' => $this->getPassword(), ':guest_key' => $this->getGuestKey()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name, $new_password)
        {
            $this->setName($new_name);
            $this->setPassword($new_password);
            $update = $GLOBALS['DB']->prepare("UPDATE users SET name = :name, password = :password WHERE id = :id;");
            $update->execute([':name' => $this->getName(), ':password' => $this->getPassword(), ':id' => $this->getId()]);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM users WHERE id = {$this->getId()};");
        }

        static function find($id)
        {
            $returned_user = $GLOBALS['DB']->query("SELECT * FROM users WHERE id = {$id};");
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['name', 'password', 'guest_key', 'id']);
            return $user[0];
        }

        static function getAll()
        {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            if ($returned_users) {
                $users = $returned_users->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['name', 'password', 'guest_key', 'id']);
            } else {
                $users = [];
            }
            return $users;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM users;');
        }
    }


?>

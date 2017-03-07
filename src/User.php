<?php
    class User {
        private $name;
        private $password;
        private $id;

        function __construct($name, $password, $id = null)
        {
            $this->name = $name;
            $this->password = $password;
            $this->id = $id;
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

        function getId()
        {
            return $this->id;
        }

        function logIn($password)
        {
            if ($password == $this->getPassword()) {
                $_SESSION['user'] = $this;
            }
        }

        function logOut()
        {
            $_SESSION['user'] = [];
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO users (name, password) VALUES (:name, :password);");
            $save->execute([':name' => $this->getName(), ':password' => $this->getPassword()]);
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
            $user = $returned_user->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['name', 'password', 'id']);
            return $user[0];
        }

        static function getAll()
        {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            if ($returned_users) {
                $users = $returned_users->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User', ['name', 'password', 'id']);
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

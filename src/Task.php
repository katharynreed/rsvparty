<?php
    class Task {
        private $name;
        private $description;
        private $event_id;
        private $id;

        function __construct($name, $description, $event_id, $id = null)
        {
            $this->name = $name;
            $this->description = $description;
            $this->event_id = $event_id;
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

        function setDescription($description)
        {
            $this->description = $description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getEventId()
        {
            return $this->event_id;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO tasks (name, description, event_id) VALUES (:name, :description, :event_id);");
            $save->execute([':name' => $this->getName(), ':description' => $this->getDescription(), ':event_id' => $this->getEventId()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name, $new_description)
        {
            $this->setName($new_name);
            $this->setDescription($new_description);
            $update = $GLOBALS['DB']->prepare("UPDATE tasks SET name = :name, description = :description WHERE id = :id;");
            $update->execute([':name' => $this->getName(), ':description' => $this->getDescription(), ':id' => $this->getId()]);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            if ($returned_tasks) {
                $tasks = $returned_tasks->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Task', ['name', 'description', 'event_id', 'id']);
            } else {
                $tasks = [];
            }
            return $tasks;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks;");
        }

    }
?>

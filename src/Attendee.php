<?php

    require_once 'Task.php';

    class Attendee {

        private $name;
        private $event_id;
        private $rsvp;
        private $id;

        function __construct($name, $event_id, $rsvp = 0, $id = null)
        {
            $this->name = $name;
            $this->event_id = $event_id;
            $this->rsvp = $rsvp;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getEventId()
        {
            return $this->event_id;
        }

        function setRsvp($rsvp)
        {
            $this->rsvp = $rsvp;
        }

        function getRsvp()
        {
            return $this->rsvp;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO attendees (name, event_id, rsvp) VALUES (:name, :event_id, :rsvp);");
            $save->execute([':name' => $this->getName(), ':event_id' => $this->getEventId(), ':rsvp' => $this->getRsvp()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name)
        {
            $this->setName($new_name);
            $update = $GLOBALS['DB']->prepare("UPDATE attendees SET name = :name WHERE id = :id;");
            $update->execute([':name' => $this->getName(), ':id' => $this->getId()]);
        }

        function updateRsvp($new_rsvp)
        {
            $this->setRsvp($new_rsvp);
            $update = $GLOBALS['DB']->prepare("UPDATE attendees SET rsvp = :rsvp WHERE id = :id;");
            $update->execute([':rsvp' => $this->getRsvp(), ':id' => $this->getId()]);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM attendees WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM attendees_tasks WHERE attendee_id = {$this->getId()};");
        }

        function addTask($id)
        {
            $GLOBALS['DB']->exec("INSERT INTO attendees_tasks (attendee_id, task_id) VALUES ({$this->getId()}, {$id});");
        }

        function getTasks()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT tasks.* FROM attendees
                            JOIN attendees_tasks ON (attendees_tasks.attendee_id = attendees.id)
                            JOIN tasks ON (tasks.id = attendees_tasks.task_id)
                            WHERE attendees.id = {$this->getId()};");
            $tasks = $returned_tasks->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Task', ['name', 'description', 'event_id', 'rsvp', 'id']);
            return $tasks;
        }

        static function getAll()
        {
            $returned_attendees = $GLOBALS['DB']->query("SELECT * FROM attendees;");
            if ($returned_attendees) {
                $attendees = $returned_attendees->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Attendee', ['name', 'event_id', 'rsvp', 'id']);
            } else {
                $attendees = [];
            }
            return $attendees;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM attendees;");
            $GLOBALS['DB']->exec("DELETE FROM attendees_tasks;");
        }
    }

?>

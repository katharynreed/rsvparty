<?php
    class Attendee {

        private $name;
        private $event_id;
        private $id;

        function __construct($name, $event_id, $id = null)
        {
            $this->name = $name;
            $this->event_id = $event_id;
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

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $save = $GLOBALS['DB']->prepare("INSERT INTO attendees (name, event_id) VALUES (:name, :event_id);");
            $save->execute([':name' => $this->getName(), ':event_id' => $this->getEventId()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_attendees = $GLOBALS['DB']->query("SELECT * FROM attendees;");
            if ($returned_attendees) {
                $attendees = $returned_attendees->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Attendee', ['name', 'event_id', 'id']);
            } else {
                $attendees = [];
            }
            return $attendees;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM attendees;");
        }
    }

?>

<?php
  class Event {

    private $user_id;
    private $name;
    private $date_time;
    private $description;
    private $location;

    function __construct($user_id, $name, $date_time, $description, $location, $id=null)
    {
      $this->user_id = $user_id;
      $this->name = $name;
      $this->date_time = $date_time;
      $this->description = $description;
      $this->location = $location;
      $this->id = $id;
    }

    function getUserId()
    {
        return $this->user_id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function getDateTime()
    {
        return $this->date_time;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($new_description)
    {
        $this->description = $new_description;
    }

    function getLocation()
    {
        return $this->location;
    }

    function setLocation($new_location)
    {
        $this->location = $new_location;
    }

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $exec = $GLOBALS['DB']->prepare("INSERT INTO events (user_id, name, date_time, description, location) VALUES (:user_id, :name, :date_time, :description, :location);");
        $exec->execute([':user_id' => $this->getUserId(), ':name' => $this->getName(), ':date_time' => $this->getDateTime(), ':description' => $this->getDescription(), ':location' => $this->getLocation()]);
        $this->id = $GLOBALS['DB']->lastInsertId();
        }

    static function getAll()
    {
        $returned_events = $GLOBALS['DB']->query("SELECT * FROM events;");
        $events = [];
        foreach ($returned_events as $event) {
            $user_id = $event['user_id'];
            $name = $event['name'];
            $date_time = $event['date_time'];
            $description = $event['description'];
            $location = $event['location'];
            $id = $event['id'];
            $new_event = new Event ($user_id, $name, $date_time, $description, $location, $id);
            array_push($events, $new_event);
        }
        return $events;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM events;");
    }

    static function find()
    {
        $found_event;
        $events = Event::getAll();
        foreach($events as $event) {
            if ($event->getId() == $id) {
                $found_event = $event;
            }
        }
        return $found_event;
    }

  }

?>

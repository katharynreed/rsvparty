<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Attendee.php";
    require_once __DIR__."/../src/Event.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/User.php";

    session_start();
    if (empty($_SESSION['user'])) {
        $_SESSION['user'] = [];
        $_SESSION['attendee'] = [];
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app['debug'] = true;

    $server = 'mysql:host=localhost:8889;dbname=rsvparty';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->get('/', function() use($app) {

    return $app['twig']->render('root.html.twig');
    });

    $app->get('/error', function() use($app) {
        $result = 'hello';
        return $app["twig"]->render("error.html.twig", ['result' => $result]);
    });

    $app->post('/login', function() {
        $user = User::findByUsername($_POST['username']);
        if ($user) {
            $response = $user->logIn($_POST['password']);
            return json_encode($response);
        } else {
            return json_encode("username");
        }
    });

    $app->get('/event_creator/{id}', function($id) use($app) {
        $user = User::find($id);
        return $app['twig']->render('create_event.html.twig', ['user' => $user]);
    });

    $app->post('/create_event', function() use ($app) {
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $date_time = $_POST['date_time'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $new_event = new Event ($user_id, $name, $date_time, $description, $location);
        $new_event->save();
        return $app->redirect('');
    });

    $app->get('/event_page/{id}', function($id) use ($app) {
        $attendees = Attendee::getAll();
        $event = Event::find($id);
        $key = 'AIzaSyCxVtVkvIYvgnBsEUQ9eKpOHKPQuJOjrBM';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($event->getLocation())."&key=AIzaSyCxVtVkvIYvgnBsEUQ9eKpOHKPQuJOjrBM";

        $lat_long = json_decode(file_get_contents($url));
        $lat = $lat_long->results[0]->geometry->location->lat;
        $long = $lat_long->results[0]->geometry->location->lng;

        return $app['twig']->render('event_page.html.twig', ['attendees' => $attendees, 'event' => $event, 'lat' => $lat, 'long' => $long, 'key' => $key]);
    });

    $app->patch('/event_page/editname/{id}', function($id) use ($app) {
        $new_name = $_POST['new_name'];
        updateName($new_name);
        $event = Event::findAll();
        return $app->redirect('/event_page/'.$id);
    });

    $app->patch('/event_page/editdate_time/{id}', function($id) use ($app) {
        $new_date_time = $_POST['new_date_time'];
        updateDateTime($new_date_time);
        $event = Event::findAll();
        return $app->redirect('/event_page/'.$id);
    });

    $app->patch('/event_page/editdescription/{id}', function($id) use ($app) {
        $new_description = $_POST['new_description'];
        updateDescription($new_description);
        $event = Event::findAll();
        return $app->redirect('/event_page/'.$id);
    });

    $app->patch('/event_page/editlocation/{id}', function($id) use ($app) {
        $new_location = $_POST['new_location'];
        updateLocation($new_location);
        $event = Event::findAll();
        return $app->redirect('/event_page/'.$id);
    });

    return $app;
?>

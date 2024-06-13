<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('guest', 'SecurityController');
Router::get('error404', 'DefaultController');

Router::post('login', 'SecurityController');
Router::post('password', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('logout', 'SecurityController');
Router::post('search', 'EventsController');

if (isset($_SESSION['email'])) {

    if ($_SESSION['role'] !== 3) {
        Router::post('add_event', 'EventsController');
        Router::get('remove_event', 'EventsController');
        Router::get('attend_event', 'EventsController');
        Router::get('cancel_attendance', 'EventsController');
        Router::get('your_events', 'EventsController');
    }

    Router::post('event_details', 'EventsController');
    Router::get('events', 'EventsController');
}

Router::run($path);
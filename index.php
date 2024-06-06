<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');

Router::get('error404', 'DefaultController');
Router::get('events', 'DefaultController');

Router::get('login', 'SecurityController');
Router::get('password', 'SecurityController');
Router::get('register', 'SecurityController');

Router::run($path);
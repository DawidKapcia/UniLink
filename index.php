<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('start', 'DefaultController');
Router::get('login', 'DefaultController');
Router::get('password', 'DefaultController');
Router::get('register', 'DefaultController');

Router::run($path);
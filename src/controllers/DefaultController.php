<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function start()
    {
        $this->render('start');
    }

    public function login()
    {
        $this->render('login');
    }

    public function password()
    {
        $this->render('password');
    }

    public function register()
    {
        $this->render('register');
    }
}
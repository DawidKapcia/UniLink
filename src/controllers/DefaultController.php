<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function error404()
    {
        $this->render('error404');
    }

    public function index()
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
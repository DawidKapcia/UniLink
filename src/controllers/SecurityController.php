<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';

class SecurityController extends AppController {

    public function login()
    {   
        $user = new User('admin@unilink.pl', 'admin', 'Johnny', 'Snow');

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User does not exist!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        return $this->render('events');
    }

    public function register()
    {
        $user = new User('admin@unilink.pl', 'admin', 'Johnny', 'Snow');

        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];

        if ($user->getEmail() === $email) {
            return $this->render('register', ['messages' => ['Account already exists!']]);
        }

        return $this->render('events');
    }

    public function password()
    {
        if (!$this->isPost()) {
            return $this->render('password');
        }

        $new_password = $_POST['new-password'];
        $repeated_password = $_POST['repeated-password'];

        if ($new_password !== $repeated_password) {
            return $this->render('password', ['messages' => ['Passwords do not match!']]); 
        }

        return $this->render('login');
    }
}
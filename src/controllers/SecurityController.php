<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/../repositories/UserRepository.php';

class SecurityController extends AppController {

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {   

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found!']]);
        }

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
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
        $password = md5($_POST['password']);

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

        $this->userRepository->createSession($user);
 
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/events");
    }

    public function register()
    {

        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $firstname = $_POST['first-name'];
        $lastname = $_POST['last-name'];
        $university = $_POST['university'];
        $password = $_POST['password'];
        
        if (!is_null($this->userRepository->getUser($email))) {
            return $this->render('register', ['messages' => ['Account already exists!']]);
        }
        
        $user = new User($email, md5($password), $firstname, $lastname, $university);
        $this->userRepository->addUser($user);

        return $this->render('login');
    }

    public function password()
    {
        if (!$this->isPost()) {
            return $this->render('password');
        }

        $email = $_POST['email'];
        $new_password = $_POST['new-password'];
        $repeated_password = $_POST['repeated-password'];

        if ($new_password !== $repeated_password) {
            return $this->render('password', ['messages' => ['Passwords do not match!']]); 
        }

        $user = $this->userRepository->getUser($email);
        $this->userRepository->changePassword($user, md5($new_password));
        
        return $this->render('login');
    }

    public function logout() {
        
        session_unset();
        session_destroy();
    
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}");
    }

    public function guest() {

        $user = $this->userRepository->getUser('guest@unilink.com');
        $this->userRepository->createSession($user);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/events");
    }
}
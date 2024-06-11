<?php

class User {
    private $email;
    private $password;
    private $firstname;
    private $lastname;

    public function __construct(
        string $email,
        string $password,
        string $firstname,
        string $lastname
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }  
}
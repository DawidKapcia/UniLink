<?php

class User {
    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $university;
    private $role;
    private $image;

    public function __construct(
        string $email,
        string $password,
        string $firstname,
        string $lastname,

        $university = "",
        $role = 2,
        $image = ""
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->university = $university;
        $this->role = $role;
        $this->image = $image;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function setEmail(string $email) 
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password) 
    {
        $this->password = $password;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname) 
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function setLastname(string $lastname) 
    {
        $this->lastname = $lastname;
    }

    public function getUniversity()
    {
        return $this->university;
    }
    
    public function setUniversity(string $university) 
    {
        $this->university = $university;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(string $image) 
    {
        $this->image = $image;
    }
}
<?php

class Event {
    private $id;
    private $title;
    private $date;
    private $hour;
    private $max_slots;
    private $address;
    private $city;
    private $zip_code;
    private $description;
    private $image;

    public function __construct($title, $date, $hour, $max_slots, $address, $city, $zip_code, $description, $image, $enroled = null, $id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->hour = $hour;
        $this->max_slots = $max_slots;
        $this->enroled = $enroled;
        $this->address = $address;
        $this->city = $city;
        $this->zip_code = $zip_code;
        $this->description = $description;
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getHour()
    {
        return $this->hour;
    }

    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    public function getSlots()
    {
        return $this->max_slots;
    }

    public function setSlots($max_slots)
    {
        $this->max_slots = $max_slots;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getZip()
    {
        return $this->zip_code;
    }

    public function setZip($zip_code)
    {
        $this->zip_code = $zip_code;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getEnroled()
    {
        return $this->enroled;
    } 
    
    public function setEnroled()
    {
        $this->enroled = $enroled;
    } 
}
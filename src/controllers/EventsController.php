<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Event.php';
require_once __DIR__ .'/../repositories/EventRepository.php';

class EventsController extends AppController {

    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $eventRepository;

    public function __construct()
    {
        parent::__construct();
        $this->eventRepository = new EventRepository();
    }

    public function add_event()
    {   
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            
            move_uploaded_file(
                $_FILES['file']['tmp_name'], 
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            $event = new Event($_POST['title'], $_POST['date'], $_POST['max_slots'], $_POST['address'], $_POST['city'], $_POST['zip_code'], $_POST['description'], $_FILES['file']['name']);
            $this->eventRepository->addEvent($event);

            return $this->render('events', ['messages' => $this->message, 'event' => $event]);
        }
        return $this->render('add_event', ['messages' => $this->message]);
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large!';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported!';
            return false;
        }
        return true;
    }
}
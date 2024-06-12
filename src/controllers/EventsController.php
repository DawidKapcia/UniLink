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

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->eventRepository->getEventByTitle($decoded['search']));
        }
    }

    public function events()
    {
        $events = $this->eventRepository->getEvents();
        return $this->render('events', ['events' => $events]);
    }

    public function your_events()
    {
        $events = $this->eventRepository->getYourEvents($_SESSION['email']);
        return $this->render('events', ['events' => $events]);
    }

    public function add_event()
    {   
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            
            move_uploaded_file(
                $_FILES['file']['tmp_name'], 
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            $event = new Event($_POST['title'], $_POST['date'], $_POST['hour'], $_POST['max_slots'], $_POST['address'], $_POST['city'], $_POST['zip_code'], $_POST['description'], $_FILES['file']['name']);
            $this->eventRepository->addEvent($event);

            return $this->events();
        }
        return $this->render('add_event', ['messages' => $this->message]);
    }

    public function event_details() {

        $id = $_GET["id"];
        $event = $this->eventRepository->getEvent($id);

        if (!$event) {
            return $this->render('error404');
        }

        $this->render('event_details', ['event' => $event]);
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
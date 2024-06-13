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
        $this->eventRepository->removeOldEvents();
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
        $is_enroled = $this->eventRepository->isYourEvent($id);

        if (!$event) {
            return $this->render('error404');
        }

        return $this->render('event_details', ['event' => $event, 'is_enroled' => $is_enroled['is_your_event']]);
    }

    public function remove_event() 
    {
        $id = $_GET["id"];

        if (!$this->eventRepository->getEvent($id)) {
            return $this->render('error404');
        }

        if ($_SESSION['role'] === 1) {
            $this->eventRepository->removeEvent($id);
        }

        return $this->events();
    }

    public function attend_event()
    {
        $id_event = $_GET["id"];
        $id_user = $_SESSION["id"];

        if ($_SESSION['role'] !== 3) {

            $event = $this->eventRepository->getEvent($id_event);
            $enroled = $event->getEnroled();
            $maxslots = $event->getSlots();

            if ($enroled < $maxslots) {
                $this->eventRepository->attendEvent($id_event, $id_user);
            }
            else {
                return $this->render('event_details', ['event' => $event, 'is_enroled' => null, 'messages' => ['Too many participants!']]);
            }
        }

        return $this->events();
    }

    public function cancel_attendance()
    {
        $id_event = $_GET["id"];
        $id_user = $_SESSION["id"];

        if ($_SESSION['role'] !== 3) {
            $this->eventRepository->cancelAttendance($id_event, $id_user);
        }

        return $this->events();
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
<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Event.php';

class EventRepository extends Repository
{

    public function getEvent(int $id): ?Event
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events WHERE id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event == false) {
            return null;
        }

        return new Event(
            $event['name'],
            $event['date'],
            $event['hour'],
            $event['maxslots'],
            $event['address'],
            $event['city'],
            $event['zipcode'],
            $event['description'],
            $event['image'],
            $event['enroled'],
            $event['id']
        );
    }

    public function addEvent(Event $event): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.events(
            name, description, address, city, zipcode, date, hour, maxslots, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);');

        $stmt->execute([
            $event->getTitle(),
            $event->getDescription(),
            $event->getAddress(),
            $event->getCity(),
            $event->getZip(),
            $event->getDate(),
            $event->getHour(),
            $event->getSlots(),
            $event->getImage()]);
    }

    public function getEvents(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events ORDER BY id;');

        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event) {
            
            $result[] = new Event(
                $event['name'],
                $event['date'],
                $event['hour'],
                $event['maxslots'],
                $event['address'],
                $event['city'],
                $event['zipcode'],
                $event['description'],
                $event['image'],
                $event['enroled'],
                $event['id']
            );
        }

        return $result;
    }

    public function getYourEvents(string $email): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT id_event FROM public.attendance a 
            INNER JOIN public.users u ON a.id_user = u.id 
            INNER JOIN public.details d ON u.detail = d.id
            WHERE d.email = :email');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $event_ids = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($event_ids)) {
            return $result;
        }

        foreach ($event_ids as $id) {
            $result[] = $this->getEvent($id);
        }

        return $result;
    }

    public function getEventByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events WHERE LOWER(name) LIKE :search OR LOWER(description) LIKE :search ORDER BY id');

        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
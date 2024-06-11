<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Event.php';

class EventRepository extends Repository
{

    public function getProject(int $id): ?Project
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events WHERE id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($project == false) {
            return null;
        }

        return new Event(
            $event['title'],
            $event['date'],
            $event['max_slots'],
            $event['address'],
            $event['city'],
            $event['zip_code'],
            $event['description'],
            $event['image']
        );
    }

    public function addEvent(Event $event): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.events(
            name, description, address, city, zipcode, date, maxslots, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?);');

        $stmt->execute([
            $event->getTitle(),
            $event->getDescription(),
            $event->getAddress(),
            $event->getCity(),
            $event->getZip(),
            $event->getDate(),
            $event->getSlots(),
            $event->getImage()]);
    }

    public function getEvents(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events;');

        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($projects as $project) {
            
            $result[] = new Event(
                $event['title'],
                $event['date'],
                $event['max_slots'],
                $event['address'],
                $event['city'],
                $event['zip_code'],
                $event['description'],
                $event['image']
            );
        }

        return $result;
    }

    public function getEventByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
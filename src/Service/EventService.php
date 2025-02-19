<?php

namespace App\Service;

use App\DTO\EventDTO;
use App\Entity\Event;
use App\Repository\EventTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class EventService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventTypeRepository $eventTypeRepository,
    ) {
    }

    public function createEventFromDTO(EventDTO $eventDTO): Event
    {
        $eventType = $this->eventTypeRepository->findOneBy(['type' => $eventDTO->event]);
    
        if (!$eventType) {
            throw new \InvalidArgumentException('Invalid event type');
        }
    
        $event = new Event();
        $event->setType($eventType);
        $event->setMetadata($eventDTO->metadata);
    
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    
        return $event;
    }
    
}

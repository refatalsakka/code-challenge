<?php

namespace App\Controller;

use App\DTO\EventDTO;
use App\DTO\StatsDTO;
use App\Enum\EventTypeEnum;
use App\Service\EventService;
use App\Repository\EventRepository;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\Jwt\TokenFactoryInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;

#[Route('/api')]
class EventController extends AbstractController
{
    public function __construct(private EventRepository $eventRepository)
    { }

    #[Route('/events', methods: ['POST'])]
    #[OA\Post(
        summary: "Insert new Event",
        description: "Represents an event triggered in the system, including its type and associated metadata."
    )]
    public function createEvent(
        #[MapRequestPayload] EventDTO $eventDTO,
        EventService $eventService
    ): JsonResponse {
        $eventService->createEventFromDTO($eventDTO);

        return new JsonResponse(
            ['message' => 'Event created successfully'],
            JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/stats', methods: ['GET'])]
    #[OA\Get(
        summary: "Retrieve today's statistics",
        description: "Fetches the number of registrations and visitors for today.",
    )]
    public function getEvents(): JsonResponse
    {
        $registrationsToday = $this->eventRepository->getCountEventToday(EventTypeEnum::REGISTRATION);
        $visitorsToday = $this->eventRepository->getCountEventToday(EventTypeEnum::VISIT);

        $statsDTO = new StatsDTO($registrationsToday, $visitorsToday);

        return new JsonResponse($statsDTO->toArray());
    }

    #[Route('/stats-realtime', methods: ['GET'])]
    #[OA\Get(
        summary: "Retrieve today's statistics in real time",
        description: "Fetches the number of registrations and visitors for today.",
    )]
    public function sendRealTimeStats(HubInterface $hub, TokenFactoryInterface $defaultTokenFactory): JsonResponse
    {
        $registrationsToday = $this->eventRepository->getCountEventToday(EventTypeEnum::REGISTRATION);
        $visitorsToday = $this->eventRepository->getCountEventToday(EventTypeEnum::VISIT);

        $statsDTO = new StatsDTO($registrationsToday, $visitorsToday);

        $jwt = $defaultTokenFactory->create([
            'mercure' => [
                'publish' => ['/api/stats']
            ]
        ]);
        
        $update = new Update(
            '/api/stats',
            json_encode($statsDTO->toArray()),
            false,
            $jwt
        );

        $hub->publish($update);

        return new JsonResponse($statsDTO->toArray());
    }
}


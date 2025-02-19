<?php

namespace App\DTO;

use App\Validator\IsValidJson;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "EventDTO",
    description: "A DTO to insert the event for today.",
    type: "object"
)]
class EventDTO
{
    public function __construct(
        #[OA\Property(
            type: "string",
            description: "The event name",
            example: "registration"
        )]
        #[Assert\NotBlank]
        public readonly string $event,

        #[OA\Property(
            type: "object",
            description: "Metadata associated with the event",
            example: null
        )]
        #[IsValidJson]
        public readonly mixed $metadata = null
    ) {
    }
}

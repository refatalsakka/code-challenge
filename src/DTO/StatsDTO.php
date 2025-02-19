<?php

namespace App\DTO;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "StatsDTO",
    description: "A DTO representing the statistics for today.",
    type: "object"
)]
class StatsDTO
{
    public function __construct(
        #[OA\Property(
            type: "integer",
            description: "The number of registrations today.",
            example: 150
        )]
        private readonly int $registrations,

        #[OA\Property(
            type: "integer",
            description: "The number of visitors today.",
            example: 1200
        )]
        private readonly int $visitors,
    ) {
    }

    public function toArray(): array
    {
        return [
            'registrations' => $this->registrations,
            'visitors' => $this->visitors,
        ];
    }
}
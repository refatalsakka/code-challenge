<?php

namespace App\DataFixtures;

use App\Entity\EventType;
use App\Enum\EventTypeEnum;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class EventTypeFixture extends BaseFixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $eventTypes = EventTypeEnum::cases();

        foreach ($eventTypes as $eventType) {
            $eventTypeEntity = new EventType();
            $eventTypeEntity->setType($eventType);

            $manager->persist($eventTypeEntity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['prod', 'dev'];
    }
}

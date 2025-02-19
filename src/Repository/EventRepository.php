<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Enum\EventTypeEnum;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getCountEventToday(EventTypeEnum $eventType): int
    {
        $startOfDay = new \DateTimeImmutable('today');
        $endOfDay = new \DateTimeImmutable('+1 day');
    
        return $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->join('e.type', 't')
            ->where('t.type = :eventTypeName')
            ->andWhere('e.createdAt >= :startOfDay')
            ->andWhere('e.createdAt < :endOfDay')
            ->setParameter('eventTypeName', $eventType->value)
            ->setParameter('startOfDay', $startOfDay)
            ->setParameter('endOfDay', $endOfDay)
            ->getQuery()
            ->getSingleScalarResult();
    }
}

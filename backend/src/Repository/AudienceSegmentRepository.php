<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AudienceSegment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AudienceSegment>
 */
class AudienceSegmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AudienceSegment::class);
    }
}

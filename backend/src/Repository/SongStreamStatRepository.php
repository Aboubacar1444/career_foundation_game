<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SongStreamStat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SongStreamStat>
 */
class SongStreamStatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongStreamStat::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CharacterUnlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CharacterUnlock>
 */
class CharacterUnlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterUnlock::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CertificationDefinition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CertificationDefinition>
 */
class CertificationDefinitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CertificationDefinition::class);
    }
}

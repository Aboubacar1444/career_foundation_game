<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProfessionalGrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProfessionalGrade>
 */
class ProfessionalGradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfessionalGrade::class);
    }
}

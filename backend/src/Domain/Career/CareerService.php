<?php

declare(strict_types=1);

namespace App\Domain\Career;

use App\Entity\Career;
use App\Entity\CharacterUnlock;
use App\Entity\Unlock;
use App\Repository\CharacterUnlockRepository;
use App\Repository\UnlockRepository;
use Doctrine\ORM\EntityManagerInterface;

class CareerService
{
    public function __construct(
        private readonly UnlockRepository $unlockRepository,
        private readonly CharacterUnlockRepository $characterUnlockRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Invariant #2: Professional unlocks are server-validated.
     * Checks if a character meets the requirements for a given unlock before granting it.
     */
    public function validateUnlock(Career $career, Unlock $unlock): bool
    {
        if (!$unlock->isActive()) {
            return false;
        }

        $requirements = $unlock->getRequirementsJson();
        if ($requirements === null) {
            return true;
        }

        if (isset($requirements['min_level']) && $career->getInternalLevel() < $requirements['min_level']) {
            return false;
        }

        if (isset($requirements['min_grade_rank'])) {
            $grade = $career->getProfessionalGrade();
            if ($grade->getRankOrder() < $requirements['min_grade_rank']) {
                return false;
            }
        }

        if (isset($requirements['min_reputation']) && $career->getReputationScore() < $requirements['min_reputation']) {
            return false;
        }

        return true;
    }

    /**
     * Grants an unlock to a character after server-side validation.
     * Invariant #2: returns false if validation fails instead of granting.
     */
    public function grantUnlock(Career $career, Unlock $unlock): ?CharacterUnlock
    {
        if (!$this->validateUnlock($career, $unlock)) {
            return null;
        }

        $existing = $this->characterUnlockRepository->findOneBy([
            'character' => $career->getCharacter(),
            'unlock' => $unlock,
        ]);

        if ($existing !== null) {
            return $existing;
        }

        $characterUnlock = new CharacterUnlock($career->getCharacter(), $unlock);
        $this->entityManager->persist($characterUnlock);
        $this->entityManager->flush();

        return $characterUnlock;
    }

    /**
     * Invariant #4: Career decline does not erase XP, level, or historical peak grade.
     * Only reputation, popularity, and career state are affected.
     */
    public function decline(Career $career, \App\Enum\CareerState $newState): void
    {
        $career->decline($newState);
        $this->entityManager->flush();
    }
}

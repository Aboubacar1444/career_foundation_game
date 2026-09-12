<?php

declare(strict_types=1);

namespace App\Tests\Domain\Career;

use App\Entity\Career;
use App\Entity\Character;
use App\Entity\CharacterUnlock;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Language;
use App\Entity\Player;
use App\Entity\ProfessionalGrade;
use App\Entity\Unlock;
use App\Enum\CareerState;
use App\Enum\Sex;
use App\Repository\CharacterUnlockRepository;
use App\Repository\UnlockRepository;
use App\Domain\Career\CareerService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CareerServiceTest extends TestCase
{
    private UnlockRepository $unlockRepository;
    private CharacterUnlockRepository $characterUnlockRepository;
    private EntityManagerInterface $entityManager;
    private CareerService $careerService;

    protected function setUp(): void
    {
        $this->unlockRepository = $this->createMock(UnlockRepository::class);
        $this->characterUnlockRepository = $this->createMock(CharacterUnlockRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->careerService = new CareerService(
            $this->unlockRepository,
            $this->characterUnlockRepository,
            $this->entityManager,
        );
    }

    private function createCareerWithGrade(int $level, int $gradeRank, int $reputation): Career
    {
        $player = new Player('ext-1');
        $language = new Language('fr', 'French');
        $country = new Country('ML', 'Mali', 'XOF', $language);
        $city = new City($country, 'Bamako', 500000, 0.6);
        $character = new Character($player, 'Amadou', Sex::Male, $country, $city);

        $grade = $this->createMock(ProfessionalGrade::class);
        $grade->method('getRankOrder')->willReturn($gradeRank);
        $grade->method('getId')->willReturn(1);

        $career = new Career($character, $grade);
        $career->setInternalLevel($level);
        $career->setReputationScore($reputation);

        return $career;
    }

    public function testValidateUnlockReturnsTrueWhenNoRequirements(): void
    {
        $career = $this->createCareerWithGrade(10, 3, 50);

        $unlock = $this->createMock(Unlock::class);
        $unlock->method('isActive')->willReturn(true);
        $unlock->method('getRequirementsJson')->willReturn(null);

        $result = $this->careerService->validateUnlock($career, $unlock);

        $this->assertTrue($result);
    }

    public function testValidateUnlockFailsWhenInactive(): void
    {
        $career = $this->createCareerWithGrade(10, 3, 50);

        $unlock = $this->createMock(Unlock::class);
        $unlock->method('isActive')->willReturn(false);

        $result = $this->careerService->validateUnlock($career, $unlock);

        $this->assertFalse($result);
    }

    public function testValidateUnlockFailsWhenLevelTooLow(): void
    {
        $career = $this->createCareerWithGrade(5, 3, 50);

        $unlock = $this->createMock(Unlock::class);
        $unlock->method('isActive')->willReturn(true);
        $unlock->method('getRequirementsJson')->willReturn(['min_level' => 10]);

        $result = $this->careerService->validateUnlock($career, $unlock);

        $this->assertFalse($result);
    }

    public function testValidateUnlockFailsWhenGradeTooLow(): void
    {
        $career = $this->createCareerWithGrade(10, 2, 50);

        $unlock = $this->createMock(Unlock::class);
        $unlock->method('isActive')->willReturn(true);
        $unlock->method('getRequirementsJson')->willReturn(['min_grade_rank' => 5]);

        $result = $this->careerService->validateUnlock($career, $unlock);

        $this->assertFalse($result);
    }

    public function testValidateUnlockFailsWhenReputationTooLow(): void
    {
        $career = $this->createCareerWithGrade(10, 3, 20);

        $unlock = $this->createMock(Unlock::class);
        $unlock->method('isActive')->willReturn(true);
        $unlock->method('getRequirementsJson')->willReturn(['min_reputation' => 50]);

        $result = $this->careerService->validateUnlock($career, $unlock);

        $this->assertFalse($result);
    }

    public function testValidateUnlockSucceedsWhenAllRequirementsMet(): void
    {
        $career = $this->createCareerWithGrade(15, 5, 100);

        $unlock = $this->createMock(Unlock::class);
        $unlock->method('isActive')->willReturn(true);
        $unlock->method('getRequirementsJson')->willReturn([
            'min_level' => 10,
            'min_grade_rank' => 3,
            'min_reputation' => 50,
        ]);

        $result = $this->careerService->validateUnlock($career, $unlock);

        $this->assertTrue($result);
    }

    public function testGrantUnlockReturnsNullWhenValidationFails(): void
    {
        $career = $this->createCareerWithGrade(5, 2, 20);

        $unlock = $this->createMock(Unlock::class);
        $unlock->method('isActive')->willReturn(true);
        $unlock->method('getRequirementsJson')->willReturn(['min_level' => 10]);

        $result = $this->careerService->grantUnlock($career, $unlock);

        $this->assertNull($result);
    }

    public function testDeclinePreservesXpAndHistoricalPeak(): void
    {
        $career = $this->createCareerWithGrade(20, 8, 200);
        $career->addExperienceXp(5000);

        $originalXp = $career->getExperienceXp();
        $originalLevel = $career->getInternalLevel();
        $originalPeakGrade = $career->getHistoricalPeakGradeId();

        $this->careerService->decline($career, CareerState::Declining);

        // XP must not be erased
        $this->assertSame($originalXp, $career->getExperienceXp());
        // Level must not be erased
        $this->assertSame($originalLevel, $career->getInternalLevel());
        // Historical peak grade must not be erased
        $this->assertSame($originalPeakGrade, $career->getHistoricalPeakGradeId());
        // Career state must change
        $this->assertSame(CareerState::Declining, $career->getCareerState());
    }
}

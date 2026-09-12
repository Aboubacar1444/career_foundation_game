<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Career;
use App\Entity\Character;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Language;
use App\Entity\Player;
use App\Entity\ProfessionalGrade;
use App\Enum\CareerState;
use App\Enum\Sex;
use PHPUnit\Framework\TestCase;

class CareerTest extends TestCase
{
    private function createCareer(): Career
    {
        $player = new Player('ext-1');
        $language = new Language('fr', 'French');
        $country = new Country('ML', 'Mali', 'XOF', $language);
        $city = new City($country, 'Bamako', 500000, 0.6);
        $character = new Character($player, 'Amadou', Sex::Male, $country, $city);

        $grade = new ProfessionalGrade('amateur', 'Amateur', 2, 5);

        return new Career($character, $grade);
    }

    public function testOriginCountryIsImmutable(): void
    {
        $player = new Player('ext-1');
        $language = new Language('fr', 'French');
        $country = new Country('ML', 'Mali', 'XOF', $language);
        $city = new City($country, 'Bamako', 500000, 0.6);
        $character = new Character($player, 'Amadou', Sex::Male, $country, $city);

        // Origin country is set at construction and has no setter
        $this->assertSame($country, $character->getOriginCountry());
        $this->assertSame('ML', $character->getOriginCountry()->getCode());
    }

    public function testDeclinePreservesXp(): void
    {
        $career = $this->createCareer();
        $career->addExperienceXp(1000);

        $career->decline(CareerState::Declining);

        $this->assertSame(1000, $career->getExperienceXp());
        $this->assertSame(CareerState::Declining, $career->getCareerState());
    }

    public function testDeclineDoesNotChangeLevel(): void
    {
        $career = $this->createCareer();
        $career->setInternalLevel(25);

        $career->decline(CareerState::Crisis);

        $this->assertSame(25, $career->getInternalLevel());
    }

    public function testDeclineDoesNotChangeHistoricalPeakGrade(): void
    {
        $career = $this->createCareer();
        $originalPeak = $career->getHistoricalPeakGradeId();

        $career->decline(CareerState::Recovery);

        $this->assertSame($originalPeak, $career->getHistoricalPeakGradeId());
    }

    public function testAddExperienceXpAccumulates(): void
    {
        $career = $this->createCareer();

        $career->addExperienceXp(100);
        $career->addExperienceXp(200);
        $career->addExperienceXp(50);

        $this->assertSame(350, $career->getExperienceXp());
    }

    public function testSetProfessionalGradeUpdatesHistoricalPeakWhenHigher(): void
    {
        $player = new Player('ext-1');
        $language = new Language('fr', 'French');
        $country = new Country('ML', 'Mali', 'XOF', $language);
        $city = new City($country, 'Bamako', 500000, 0.6);
        $character = new Character($player, 'Amadou', Sex::Male, $country, $city);

        $initialGrade = $this->createMock(ProfessionalGrade::class);
        $initialGrade->method('getRankOrder')->willReturn(2);
        $initialGrade->method('getId')->willReturn(1);

        $career = new Career($character, $initialGrade);
        $initialPeak = $career->getHistoricalPeakGradeId();

        $higherGrade = $this->createMock(ProfessionalGrade::class);
        $higherGrade->method('getRankOrder')->willReturn(8);
        $higherGrade->method('getId')->willReturn(10);

        $career->setProfessionalGrade($higherGrade);

        // Peak should update to the higher grade's ID
        $this->assertSame(10, $career->getHistoricalPeakGradeId());
    }

    public function testSetProfessionalGradeDoesNotLowerHistoricalPeak(): void
    {
        $player = new Player('ext-1');
        $language = new Language('fr', 'French');
        $country = new Country('ML', 'Mali', 'XOF', $language);
        $city = new City($country, 'Bamako', 500000, 0.6);
        $character = new Character($player, 'Amadou', Sex::Male, $country, $city);

        $initialGrade = $this->createMock(ProfessionalGrade::class);
        $initialGrade->method('getRankOrder')->willReturn(8);
        $initialGrade->method('getId')->willReturn(10);

        $career = new Career($character, $initialGrade);
        $initialPeak = $career->getHistoricalPeakGradeId();

        $lowerGrade = $this->createMock(ProfessionalGrade::class);
        $lowerGrade->method('getRankOrder')->willReturn(1);
        $lowerGrade->method('getId')->willReturn(5);

        $career->setProfessionalGrade($lowerGrade);

        // Peak should NOT lower
        $this->assertSame($initialPeak, $career->getHistoricalPeakGradeId());
    }
}

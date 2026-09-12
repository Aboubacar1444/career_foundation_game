<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\CareerState;
use App\Repository\CareerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CareerRepository::class)]
#[ORM\Table(name: 'career')]
class Career
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\ManyToOne(targetEntity: ProfessionalGrade::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ProfessionalGrade $professionalGrade;

    #[ORM\Column(type: Types::INTEGER)]
    private int $reputationScore = 0;

    #[ORM\Column(type: Types::INTEGER)]
    private int $popularityScore = 0;

    #[ORM\Column(type: Types::BIGINT)]
    private int $experienceXp = 0;

    #[ORM\Column(type: Types::INTEGER)]
    private int $internalLevel = 1;

    #[ORM\Column(type: Types::STRING, enumType: CareerState::class)]
    private CareerState $careerState = CareerState::Stable;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $historicalPeakGradeId = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    public function __construct(Character $character, ProfessionalGrade $professionalGrade)
    {
        $this->character = $character;
        $this->professionalGrade = $professionalGrade;
        $this->historicalPeakGradeId = $professionalGrade->getId();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getProfessionalGrade(): ProfessionalGrade
    {
        return $this->professionalGrade;
    }

    public function setProfessionalGrade(ProfessionalGrade $grade): void
    {
        $this->professionalGrade = $grade;
        if ($grade->getRankOrder() > $this->historicalPeakGradeId) {
            $this->historicalPeakGradeId = $grade->getId();
        }
    }

    public function getReputationScore(): int
    {
        return $this->reputationScore;
    }

    public function setReputationScore(int $score): void
    {
        $this->reputationScore = $score;
    }

    public function getPopularityScore(): int
    {
        return $this->popularityScore;
    }

    public function setPopularityScore(int $score): void
    {
        $this->popularityScore = $score;
    }

    public function getExperienceXp(): int
    {
        return $this->experienceXp;
    }

    public function addExperienceXp(int $xp): void
    {
        $this->experienceXp += $xp;
    }

    public function getInternalLevel(): int
    {
        return $this->internalLevel;
    }

    public function setInternalLevel(int $level): void
    {
        $this->internalLevel = $level;
    }

    public function getCareerState(): CareerState
    {
        return $this->careerState;
    }

    public function setCareerState(CareerState $state): void
    {
        $this->careerState = $state;
    }

    public function getHistoricalPeakGradeId(): ?int
    {
        return $this->historicalPeakGradeId;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateTimestamp(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * Invariant #4: Career decline does not erase XP or historical achievements.
     * This method changes career state without touching experienceXp or historicalPeakGradeId.
     */
    public function decline(CareerState $newState): void
    {
        $this->careerState = $newState;
        $this->updateTimestamp();
    }
}

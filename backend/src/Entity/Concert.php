<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ConcertRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConcertRepository::class)]
#[ORM\Table(name: 'concert')]
class Concert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\ManyToOne(targetEntity: Venue::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Venue $venue;

    #[ORM\ManyToOne(targetEntity: Market::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Market $market;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $scheduledStartAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $scheduledEndAt;

    #[ORM\Column(type: Types::INTEGER)]
    private int $simulationDurationSeconds;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $actualResolvedAt = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $status = 'scheduled';

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $outcomeJson = null;

    public function __construct(
        Character $character,
        Venue $venue,
        Market $market,
        \DateTimeImmutable $scheduledStartAt,
        \DateTimeImmutable $scheduledEndAt,
        int $simulationDurationSeconds,
    ) {
        $this->character = $character;
        $this->venue = $venue;
        $this->market = $market;
        $this->scheduledStartAt = $scheduledStartAt;
        $this->scheduledEndAt = $scheduledEndAt;
        $this->simulationDurationSeconds = $simulationDurationSeconds;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getVenue(): Venue
    {
        return $this->venue;
    }

    public function getMarket(): Market
    {
        return $this->market;
    }

    public function getScheduledStartAt(): \DateTimeImmutable
    {
        return $this->scheduledStartAt;
    }

    public function getScheduledEndAt(): \DateTimeImmutable
    {
        return $this->scheduledEndAt;
    }

    public function getSimulationDurationSeconds(): int
    {
        return $this->simulationDurationSeconds;
    }

    public function getActualResolvedAt(): ?\DateTimeImmutable
    {
        return $this->actualResolvedAt;
    }

    public function setActualResolvedAt(?\DateTimeImmutable $resolvedAt): void
    {
        $this->actualResolvedAt = $resolvedAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getOutcomeJson(): ?array
    {
        return $this->outcomeJson;
    }

    public function setOutcomeJson(?array $outcome): void
    {
        $this->outcomeJson = $outcome;
    }
}

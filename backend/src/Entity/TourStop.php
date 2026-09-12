<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TourStopRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TourStopRepository::class)]
#[ORM\Table(name: 'tour_stop')]
class TourStop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tour::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Tour $tour;

    #[ORM\ManyToOne(targetEntity: Venue::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Venue $venue;

    #[ORM\Column(type: Types::INTEGER)]
    private int $sequenceNo;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $scheduledStartAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $scheduledEndAt = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $status = 'planned';

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $outcomeJson = null;

    public function __construct(Tour $tour, Venue $venue, int $sequenceNo)
    {
        $this->tour = $tour;
        $this->venue = $venue;
        $this->sequenceNo = $sequenceNo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTour(): Tour
    {
        return $this->tour;
    }

    public function getVenue(): Venue
    {
        return $this->venue;
    }

    public function getSequenceNo(): int
    {
        return $this->sequenceNo;
    }

    public function getScheduledStartAt(): ?\DateTimeImmutable
    {
        return $this->scheduledStartAt;
    }

    public function setScheduledStartAt(?\DateTimeImmutable $start): void
    {
        $this->scheduledStartAt = $start;
    }

    public function getScheduledEndAt(): ?\DateTimeImmutable
    {
        return $this->scheduledEndAt;
    }

    public function setScheduledEndAt(?\DateTimeImmutable $end): void
    {
        $this->scheduledEndAt = $end;
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

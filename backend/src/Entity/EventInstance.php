<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EventInstanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventInstanceRepository::class)]
#[ORM\Table(name: 'event_instance')]
class EventInstance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: EventDefinition::class)]
    #[ORM\JoinColumn(nullable: false)]
    private EventDefinition $eventDefinition;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $startsAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $endsAt;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $worldStateSnapshotJson = null;

    public function __construct(
        EventDefinition $eventDefinition,
        \DateTimeImmutable $startsAt,
        \DateTimeImmutable $endsAt,
    ) {
        $this->eventDefinition = $eventDefinition;
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventDefinition(): EventDefinition
    {
        return $this->eventDefinition;
    }

    public function getStartsAt(): \DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function getEndsAt(): \DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function isActiveAt(\DateTimeImmutable $now): bool
    {
        return $now >= $this->startsAt && $now <= $this->endsAt;
    }

    public function getWorldStateSnapshotJson(): ?array
    {
        return $this->worldStateSnapshotJson;
    }

    public function setWorldStateSnapshotJson(?array $snapshot): void
    {
        $this->worldStateSnapshotJson = $snapshot;
    }
}

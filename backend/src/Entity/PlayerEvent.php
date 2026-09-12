<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PlayerEventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerEventRepository::class)]
#[ORM\Table(name: 'player_event')]
class PlayerEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: EventInstance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private EventInstance $eventInstance;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $status = 'eligible';

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $progressJson = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $resultJson = null;

    public function __construct(EventInstance $eventInstance, Character $character)
    {
        $this->eventInstance = $eventInstance;
        $this->character = $character;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventInstance(): EventInstance
    {
        return $this->eventInstance;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getProgressJson(): ?array
    {
        return $this->progressJson;
    }

    public function setProgressJson(?array $progress): void
    {
        $this->progressJson = $progress;
    }

    public function getResultJson(): ?array
    {
        return $this->resultJson;
    }

    public function setResultJson(?array $result): void
    {
        $this->resultJson = $result;
    }
}

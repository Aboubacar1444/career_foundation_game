<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\QuestStatus;
use App\Repository\QuestInstanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestInstanceRepository::class)]
#[ORM\Table(name: 'quest_instance')]
class QuestInstance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: QuestDefinition::class)]
    #[ORM\JoinColumn(nullable: false)]
    private QuestDefinition $questDefinition;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?self $parentQuestInstance = null;

    #[ORM\Column(type: Types::STRING, enumType: QuestStatus::class)]
    private QuestStatus $status = QuestStatus::Available;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $progressJson = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $completedAt = null;

    public function __construct(QuestDefinition $questDefinition, Character $character)
    {
        $this->questDefinition = $questDefinition;
        $this->character = $character;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestDefinition(): QuestDefinition
    {
        return $this->questDefinition;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getParentQuestInstance(): ?self
    {
        return $this->parentQuestInstance;
    }

    public function setParentQuestInstance(?self $parent): void
    {
        $this->parentQuestInstance = $parent;
    }

    public function getStatus(): QuestStatus
    {
        return $this->status;
    }

    public function setStatus(QuestStatus $status): void
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

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function start(): void
    {
        $this->status = QuestStatus::Active;
        $this->startedAt = new \DateTimeImmutable();
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function complete(): void
    {
        $this->status = QuestStatus::Completed;
        $this->completedAt = new \DateTimeImmutable();
    }

    public function fail(): void
    {
        $this->status = QuestStatus::Failed;
    }
}

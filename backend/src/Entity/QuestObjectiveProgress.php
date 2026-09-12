<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestObjectiveProgressRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestObjectiveProgressRepository::class)]
#[ORM\Table(name: 'quest_objective_progress')]
#[ORM\UniqueConstraint(name: 'unique_quest_obj_prog', columns: ['quest_instance_id', 'quest_objective_id'])]
class QuestObjectiveProgress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: QuestInstance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private QuestInstance $questInstance;

    #[ORM\ManyToOne(targetEntity: QuestObjective::class)]
    #[ORM\JoinColumn(nullable: false)]
    private QuestObjective $questObjective;

    #[ORM\Column(type: Types::INTEGER)]
    private int $currentValue = 0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $completedAt = null;

    public function __construct(QuestInstance $questInstance, QuestObjective $questObjective)
    {
        $this->questInstance = $questInstance;
        $this->questObjective = $questObjective;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestInstance(): QuestInstance
    {
        return $this->questInstance;
    }

    public function getQuestObjective(): QuestObjective
    {
        return $this->questObjective;
    }

    public function getCurrentValue(): int
    {
        return $this->currentValue;
    }

    public function incrementValue(int $amount = 1): void
    {
        $this->currentValue += $amount;
        if ($this->currentValue >= $this->questObjective->getTargetValue() && $this->completedAt === null) {
            $this->completedAt = new \DateTimeImmutable();
        }
    }

    public function isCompleted(): bool
    {
        return $this->completedAt !== null;
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }
}

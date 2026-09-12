<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestObjectiveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestObjectiveRepository::class)]
#[ORM\Table(name: 'quest_objective')]
class QuestObjective
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: QuestDefinition::class)]
    #[ORM\JoinColumn(nullable: false)]
    private QuestDefinition $questDefinition;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $objectiveType;

    #[ORM\Column(type: Types::INTEGER)]
    private int $targetValue;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $metadataJson = null;

    public function __construct(
        QuestDefinition $questDefinition,
        string $code,
        string $objectiveType,
        int $targetValue,
    ) {
        $this->questDefinition = $questDefinition;
        $this->code = $code;
        $this->objectiveType = $objectiveType;
        $this->targetValue = $targetValue;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestDefinition(): QuestDefinition
    {
        return $this->questDefinition;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getObjectiveType(): string
    {
        return $this->objectiveType;
    }

    public function getTargetValue(): int
    {
        return $this->targetValue;
    }

    public function getMetadataJson(): ?array
    {
        return $this->metadataJson;
    }
}

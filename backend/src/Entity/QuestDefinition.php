<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestDefinitionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestDefinitionRepository::class)]
#[ORM\Table(name: 'quest_definition')]
class QuestDefinition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50, unique: true)]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 20)]
    private string $type;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $prerequisitesJson = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $rewardsJson = null;

    public function __construct(string $code, string $name, string $type)
    {
        $this->code = $code;
        $this->name = $name;
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrerequisitesJson(): ?array
    {
        return $this->prerequisitesJson;
    }

    public function getRewardsJson(): ?array
    {
        return $this->rewardsJson;
    }
}
